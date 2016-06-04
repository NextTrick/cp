<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class MisDatosController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $usuario = $this->_getUsuarioData();
        
        if (!$this->request->isPost()) {
            $this->_getUsuarioService()->actualizarUsuarioDesdeTrueFi($usuario->id);
        }
        
        $criteria = array('where' => array('id' => $usuario->id));
        $usuarioData = $this->_getUsuarioService()->getRepository()->findOne($criteria);

        $config = $this->getServiceLocator()->get('config');
        $urlImg = isset($config['fileDir']['usuario_usuario']['down']) ? $config['fileDir']['usuario_usuario']['down'] : null;

        $imagen = null;
        $form = $this->_getMisDatosForm();
        if (!empty($usuarioData)) {
            unset($usuarioData['password']);
            $departamentoId = $usuarioData['departamento_id'];
            $provinciaId = $usuarioData['provincia_id'];
            $departamentos = $this->_getUbigeoService()->getPeDepartamentos();
            $form->get('departamento_id')->setValueOptions($departamentos);
            $provincias = $this->_getUbigeoService()->getProvincias($departamentoId);
            $form->get('provincia_id')->setValueOptions($provincias);
            $distritos = $this->_getUbigeoService()->getDistritos($provinciaId);
            $form->get('distrito_id')->setValueOptions($distritos);
            if (!empty($usuarioData['fecha_nac'])) {
                $partDate = explode('-', $usuarioData['fecha_nac']);
                if (count($partDate) >= 3) {
                    $usuarioData['anio'] = $partDate[0];
                    $usuarioData['mes'] = $partDate[1];
                    $usuarioData['dia'] = $partDate[2];
                }
            }
            
            $form->setData($usuarioData);
            $imagen = empty($usuarioData['imagen']) ? 'user-web-default.png' : $usuarioData['imagen'];
        }
        
        $form->setAttribute('action', $this->url()->fromRoute('web-mis-datos', array(
            'controller' => 'mis-datos',
        )));
        
        $request = $this->getRequest();
        $mensajeRegistro = null;
        if ($this->request->isPost()) {
            //========================== Llenar los combos =====================
            $departamentoId = $this->request->getPost('departamento_id');
            $provinciaId = $this->request->getPost('provincia_id');
            $departamentos = $this->_getUbigeoService()->getPeDepartamentos();
            $form->get('departamento_id')->setValueOptions($departamentos);
            $provincias = $this->_getUbigeoService()->getProvincias($departamentoId);
            $form->get('provincia_id')->setValueOptions($provincias);
            $distritos = $this->_getUbigeoService()->getDistritos($provinciaId);
            $form->get('distrito_id')->setValueOptions($distritos);
            //========================== Fin llenar los combos =================
            
            //========================== Aplicar filter ========================
            $data = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

            $newFileName = null;
            if (!empty($data['imagen']['name'])) {
                $ext = strtolower(pathinfo($data['imagen']['name'], PATHINFO_EXTENSION));   
                $newFileName = date('Ymd') . '-' . $usuario->id . '.' . $ext;

                $data['imagen']['name'] = $newFileName;
            }

            $changePassword = (!empty($data['password']) || !empty($data['password_repeat'])) ? true : false;
            $config = $this->getServiceLocator()->get('config');
            $form->setInputFilter(new \Application\Filter\MisDatosFilter(array(
                'uploadDir' => $config['fileDir']['usuario_usuario']['up'],
                'changePassword' => $changePassword,
            )));
            $form->setData($data);
            //========================== Fin aplicar filter ====================
            
            //========================== Validar fecha =========================
            $fechaValida = false;
            $fechaNac = null;
            if (\Common\Helpers\Util::checkDate($data['mes'], $data['dia'], $data['anio'])) {
                $fechaValida = true;
                $fechaNac = $data['anio'] . '-' . $data['mes'] . '-' . $data['dia'];
            } else {
                $form->get('dia')->setMessages(array('noValido' => 'El campo fecha no es válido.'));
            }
            //========================== Fin validar fecha =====================
            
            if ($fechaValida && $form->isValid()) {
                $data = $form->getData();
                $data['fecha_nac'] = $fechaNac;
                $data['new_file_name'] = $newFileName;
                
                $success = $this->_saveData($data, $usuarioData['id'], $usuarioData['mguid']);
                if ($success) {
                    $this->flashMessenger()->addMessage(array(
                        'success' => '<b>Felicidades</b>, tus datos fueron actualizados correctamente. ' ,
                    ));
                } else {
                    $this->flashMessenger()->addMessage(array(
                        'error' => 'Lo sentimos, no se pudo completar el proceso, por favor inténtelo más tarde.',
                    ));
                }

                return $this->redirect()->toRoute('web-mis-datos', array('controller' => 'mis-datos'));
            }
        }
        
        return new ViewModel(array(
            'urlImg' => $urlImg,
            'imagen' => $imagen,
            'form' => $form,
            'mensajeRegistro' => $mensajeRegistro,
        ));
    }
    

    private function _saveData($data, $id, $mguid)
    {
        //======================  Actualizar datos en TrueFi ===================
        $dataArray = array(
            'FIRSTNAME' => $data['nombres'],
            'LASTNAME' => $data['paterno'] . ' ' . $data['materno'],
            'EMAIL' => $data['email'],
            'IDNUMBER' => $data['di_valor'],
        );
        if (!empty($data['fecha_nac'])) {
            $dataArray['BIRTHDATE'] = $data['fecha_nac'];
        }
        $dataTrueFi = array(
            'MGUID' => $mguid,
            'Data' => $dataArray,
        );
        $result = $this->_getUsuarioService()->actualizarEnTrueFi($dataTrueFi);
        //==================== Fin  Actualizar datos en TrueFi =================

        if ($result['success']) {
            $dataIn = array(
                'email' => $data['email'],
                'nombres' => $data['nombres'],
                'paterno' => $data['paterno'],
                'materno' => $data['materno'],
                'pais_id' => $this->_getUbigeoService()->getPePaisId(),
                'departamento_id' => $data['departamento_id'],
                'provincia_id' => $data['provincia_id'],
                'distrito_id' => $data['distrito_id'],
                'di_tipo' => $data['di_tipo'],
                'di_valor' => $data['di_valor'],
                'fecha_nac' => $data['fecha_nac'],
                'fecha_edicion' => date('Y-m-d H:i:s'),
            );

            if (!empty($data['new_file_name'])) {
                $dataIn['imagen'] = $data['new_file_name'];
            }
            if (!empty($data['password'])) {
                $dataIn['password'] = \Common\Helpers\Util::passwordEncrypt($data['password'], $data['email']);
            }

            $id = $this->_getUsuarioService()->getRepository()->save($dataIn, $id);
            if (!empty($id)) {
                return true;
            }
        }
        
        return false;
    }
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    private function _getMisDatosForm()
    {
        return $this->getServiceLocator()->get('Application\Form\MisDatosForm');
    }
    
    protected function _getUbigeoService()
    {
        return $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
    }
}
