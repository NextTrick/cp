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
            $codPais = $usuarioData['cod_pais'];
            $codDep = $usuarioData['cod_depa'];
            $departamentos = $this->_getUbigeoService()->getDepartamentos($codPais);
            $form->get('cod_depa')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($codPais, $codDep);
            $form->get('cod_dist')->setValueOptions($distritos);
            
            $form->setData($usuarioData);
            $imagen = empty($usuarioData['imagen']) ? null : $urlImg . '/' . $usuarioData['imagen'];
        }
        
        $form->setAttribute('action', $this->url()->fromRoute('web-mis-datos', array(
            'controller' => 'mis-datos',
        )));
        
        $request = $this->getRequest();
        $mensajeRegistro = null;
        if ($this->request->isPost()) {
            //=========== Llenar los combos ===========
            $codPais = $this->request->getPost('cod_pais');
            $codDep = $this->request->getPost('cod_depa');
            $departamentos = $this->_getUbigeoService()->getDepartamentos($codPais);
            $form->get('cod_depa')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($codPais, $codDep);
            $form->get('cod_dist')->setValueOptions($distritos);
            
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
                    'cod_pais' => $data['cod_pais'],
                    'cod_depa' => $data['cod_depa'],
                    'cod_dist' => $data['cod_dist'],
                    'di_tipo' => $data['di_tipo'],
                    'di_valor' => $data['di_valor'],
                    'fecha_nac' => $fechaNac,
                );
                
                if (!empty($newFileName)) {
                    $dataIn['imagen'] = $newFileName;
                }
                if (!empty($data['password'])) {
                    $dataIn['password'] = \Common\Helpers\Util::passwordEncrypt($data['password'], $data['email']);
                }

                $id = $this->_getUsuarioService()->getRepository()->save($dataIn, $usuario->id);
                $mensajeRegistro = 'Lo sentimos, no se pudo completar el proceso, por favor inténtelo más tarde.';
                if (!empty($id)) {
                    $mensajeRegistro = '<h3>¡Felicidades!, tu cuenta fué actualizada correctamente.</h3>';
                    return $this->redirect()->toRoute('web-mis-datos', array('controller' => 'mis-datos'));
                }
            }
        }
        
        return new ViewModel(array(
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
