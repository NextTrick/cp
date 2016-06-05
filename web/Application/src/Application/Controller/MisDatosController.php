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
                
                $success = $this->_saveData($data, $usuarioData);
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
    

    private function _saveData($dataForm, $dataBd)
    {
        $id = $dataBd['id'];
        $email = $dataBd['email'];
        $changePassword = true;
        if (!empty($dataForm['password'])) {
            $oldPassword = \Common\Helpers\Util::passwordDecrypt($dataBd['password'], $email);
            $dataTrueFi1 = array(
                'MGUID' => $dataBd['mguid'],
                'Password' => $dataForm['password'],
                'OldPassword' => $oldPassword,
            );
            $result1 = $this->_getUsuarioService()->modificarPasswordEnTrueFi($dataTrueFi1);
            if ($result1['success']) {
                $this->_getUsuarioService()->modificarPasswordEnDb($id, $email, $dataForm['password']);
            }
            $changePassword = $result1['success'];
        }
        
        if ($changePassword) {
            $dataArray = array(
                'FIRSTNAME' => $dataForm['nombres'],
                'LASTNAME' => $dataForm['paterno'] . ' ' . $dataForm['materno'],
                'IDNUMBER' => $dataForm['di_valor'],
            );
            if (!empty($dataForm['fecha_nac'])) {
                $dataArray['BIRTHDATE'] = $dataForm['fecha_nac'];
            }
            $dataTrueFi2 = array(
                'MGUID' => $dataBd['mguid'],
                'Data' => $dataArray,
            );
            $result2 = $this->_getUsuarioService()->actualizarEnTrueFi($dataTrueFi2);
            if ($result2['success']) {
                $dataIn = array(
                    'nombres' => $dataForm['nombres'],
                    'paterno' => $dataForm['paterno'],
                    'materno' => $dataForm['materno'],
                    'pais_id' => $this->_getUbigeoService()->getPePaisId(),
                    'departamento_id' => $dataForm['departamento_id'],
                    'provincia_id' => $dataForm['provincia_id'],
                    'distrito_id' => $dataForm['distrito_id'],
                    'di_tipo' => $dataForm['di_tipo'],
                    'di_valor' => $dataForm['di_valor'],
                    'fecha_nac' => $dataForm['fecha_nac'],
                    'fecha_edicion' => date('Y-m-d H:i:s'),
                );

                if (!empty($dataForm['new_file_name'])) {
                    $dataIn['imagen'] = $dataForm['new_file_name'];
                }

                $id = $this->_getUsuarioService()->getRepository()->save($dataIn, $dataBd['id']);
                if (!empty($id)) {
                    return true;
                }
            } else {
                \Util\Common\Email::reportDebug($result2, null, 'Error modificar mis datos');
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
