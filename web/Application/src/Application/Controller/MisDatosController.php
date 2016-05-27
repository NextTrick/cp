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
        $criteria = array('where' => array('id' => $usuario->id));
        $usuarioData = $this->_getUsuarioService()->getRepository()->findOne($criteria);

        $config = $this->getServiceLocator()->get('config');
        $urlImg = isset($config['fileDir']['usuario_usuario']['down']) ? $config['fileDir']['usuario_usuario']['down'] : null;

        $imagen = null;
        $form = $this->_getMisDatosForm();
        if (!empty($usuarioData)) {
            unset($usuarioData['password']);
            $paisId = $usuarioData['pais_id'];
            $departamentoId = $usuarioData['departamento_id'];
            $departamentos = $this->_getUbigeoService()->getDepartamentos($paisId);
            $form->get('departamento_id')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($paisId, $departamentoId);
            $form->get('distrito_id')->setValueOptions($distritos);
            
            $form->setData($usuarioData);
            $imagen = empty($usuarioData['imagen']) ? 'user-web-default.png' : $usuarioData['imagen'];
        }
        
        $form->setAttribute('action', $this->url()->fromRoute('web-mis-datos', array(
            'controller' => 'mis-datos',
        )));
        
        $request = $this->getRequest();
        $mensajeRegistro = null;
        if ($this->request->isPost()) {
            //=========== Llenar los combos ===========
            $paisId = $this->request->getPost('pais_id');
            $departamentoId = $this->request->getPost('departamento_id');
            $departamentos = $this->_getUbigeoService()->getDepartamentos($paisId);
            $form->get('departamento_id')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($paisId, $departamentoId);
            $form->get('distrito_id')->setValueOptions($distritos);
            
            //=========== Aplicar filter ===========
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
            
            //=========== Validar fecha ===========
            $fechaValida = false;
            $fechaNac = null;
            if (\Common\Helpers\Util::checkDate($data['mes'], $data['dia'], $data['anio'])) {
                $fechaValida = true;
                $fechaNac = $data['anio'] . '-' . $data['mes'] . '-' . $data['dia'];
            } else {
                $form->get('dia')->setMessages(array('noValido' => 'El campo fecha no es válido.'));
            }

            if ($fechaValida && $form->isValid()) {
                $data = $form->getData();
                $dataIn = array(
                    'email' => $data['email'],
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'pais_id' => $data['pais_id'],
                    'departamento_id' => $data['departamento_id'],
                    'distrito_id' => $data['distrito_id'],
                    'di_tipo' => $data['di_tipo'],
                    'di_valor' => $data['di_valor'],
                    'fecha_nac' => $fechaNac,
                    'fecha_edicion' => date('Y-m-d H:i:s'),
                );
                
                if (!empty($newFileName)) {
                    $dataIn['imagen'] = $newFileName;
                }
                if (!empty($data['password'])) {
                    $dataIn['password'] = \Common\Helpers\Util::passwordEncrypt($data['password'], $data['email']);
                }

                $id = $this->_getUsuarioService()->getRepository()->save($dataIn, $usuario->id);
                if (!empty($id)) {
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
