<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegistroController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function completaTuRegistroAction()
    {
        $dataIni = array();
        if ($this->request->isPost()) {
            //desde formulario
            $dataIni['email'] = $this->request->getPost('email');
        } else {
            // desde red social
            $dataIni['email'] = $this->_getDataRegistroTemp('email');
        }
        
        $form = $this->_getRegistroForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-completa-tu-registro', array(
            'controller' => 'registro',
            'action' => 'completa-tu-registro',
        )));
        $form->setData($dataIni);
     
        $registroForm = (float)$this->request->getPost('registro_form');
        if ($this->request->isPost() && !$registroForm) {
            $codPais = $this->request->getPost('cod_pais');
            $codDep = $this->request->getPost('cod_depa');
            $departamentos = $this->_getUbigeoService()->getDepartamentos($codPais);
            $form->get('cod_depa')->setValueOptions($departamentos);
            $distritos = $this->_getUbigeoService()->getDistritos($codPais, $codDep);
            $form->get('cod_dist')->setValueOptions($distritos);
            
            $form->setInputFilter(new \Application\Filter\RegistroFilter());
            $data = $this->request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $gateway = $this->_getDataRegistroTemp('gateway');
                
                $redSocial = false;
                switch ($gateway) {
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_FACEBOOK:
                        $data['facebook_id'] = $this->_getDataRegistroTemp('id');
                        $redSocial = true;
                        break;
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_TWITTER:
                        $data['twitter_id'] = $this->_getDataRegistroTemp('id');
                        $redSocial = true;
                        break;
                }

                $repository = $this->_getUsuarioService()->getRepository();
                //verificar en base de datos
                $criteria = array('where' => array('email' => $data['email']));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $existsEmail = 'El correo ingresado ya fue registrado anteriormente.';
                    $form->get('email')->setMessages(array('existsEmail' => $existsEmail));
                } else {
                    $saveData = $this->_saveData($data);
                    if ($saveData['success']) {
                        $message = '<b>Felicidades, ya estás a punto de ser parte de Coney Club.</b> '
                            . 'Te hemos enviado un correo con las instrucciones para activar tu cuenta';
                        $this->flashMessenger()->addMessage(array(
                            'success' => $message,
                        ));
                        return $this->redirect()->toRoute('web-notificar');
                    } else {
                        $this->flashMessenger()->addMessage(array(
                            'error' => $saveData['message'],
                        ));
                        return $this->redirect()->toRoute('web-notificar');
                    }
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
    }
    
    private function _saveData($data)
    {
        $dataTrueFi = array(
            'FirstName' => $data['nombres'],
            'LastName' => $data['paterno'] . ' ' . $data['materno'],
            'EMail' => $data['email'],
            'Password' => $data['password'],
            'Type' => \TrueFi\Model\Service\UsuarioService::TIPO_CLIENTE,
        );

        $repository = $this->_getUsuarioService()->getRepository();
        //registrar en True-Fi
        $resultTrueFi = $this->_getUsuarioService()->registrarEnTrueFi($dataTrueFi);
        if ($resultTrueFi['success']) {
            $dataIn = array(
                'email' => $data['email'],
                'password' => \Common\Helpers\Util::passwordEncrypt($data['password'], $data['email']),
                'mguid' => $resultTrueFi['mguid'],
                'codigo_activar' => \Common\Helpers\Util::generateToken($resultTrueFi['mguid']),
                'nombres' => $data['nombres'],
                'paterno' => $data['paterno'],
                'materno' => $data['materno'],
                'di_tipo' => $data['di_tipo'],
                'di_valor' => $data['di_valor'],
                'cod_pais' => $data['cod_pais'],
                'cod_depa' => $data['cod_depa'],
                'cod_dist' => $data['cod_dist'],
                'fecha_nac' => $data['fecha_nac'],
            );
            $save = $repository->save($dataIn);
            if ($save) {
                $result['success'] = true;
                $result['message'] = null;
                $this->_removeDataRegistroTemp();
            } else {
                $result['message'] = 'Lo sentimos, no se pudo completar el '
                    . 'proceso, por favor inténtalo más tarde.';
            }
        } else {
            $result['message'] = 'Lo sentimos, no se pudo completar el '
                    . 'proceso, por favor inténtalo más tarde.';
        }
        
        return $result;
    }
    
    public function notificarAction()
    {
        return new ViewModel();
    }
    
    public function confirmarAction()
    {
        $codigo = $this->params('codigo');
        $repository = $this->_getUsuarioService()->getRepository();
        $criteria = array('where' => array('codigo_activar' => $codigo));
        $row = $repository->findOne($criteria);
        if (!empty($row)) {
            //activar en True-Fi
            $this->_getUsuarioService()->activarEnTrueFi(array('MGUID' => $codigo));
            $this->_getUsuarioService()->getRepository()->save(array(
                'estado' => 1,
                'codigo_activar' => null,
            ), $row['id']);
        }

        return new ViewModel();
    }

    public function recuperarPasswordAction()
    {
        $form = $this->_getRecuperarPasswordForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-recuperar-password', array(
            'controller' => 'registro',
            'action' => 'recuperar-password',
        )));
        
        if ($this->request->isPost()) {
            $form->setInputFilter(new \Application\Filter\RecuperarPasswordFilter());
            $data = $this->request->getPost()->toArray();
            $form->setData($data);
            
            $criteria = array('where' => array('email' => $data['email']));
            $existe = $this->_getUsuarioService()->getRepository()->findExists($criteria);
            
            $usuarioTrueFi = array();
            if ($existe === false) {
                $dataTrueFi = array(
                    'EMail' => $data['email'],
                );
                $usuarioTrueFi = $this->_getUsuarioService()->usuarioEnTrueFi($dataTrueFi);
                $existe = empty($usuarioTrueFi) ? false : true;
            }
            
            $noExistsEmail = 'El correo electrónico no se ecuentra registrado.';
            if ($existe === false) {
                $form->get('email')->setMessages(array('noExistsEmail' => $noExistsEmail));
            } elseif ($form->isValid()) {
                if (!empty($usuarioTrueFi)) {
                    //registrar usuario en el sistema con datos devueltos de TrueFi
                }

                $criteria = array('where' => array('email' => $data['email']));
                $usuario = $this->_getUsuarioService()->getRepository()->findOne($criteria);
                if (!empty($usuario)) {
                    //generar y guardar token de verificación
                    $codigoRecuperar = \Common\Helpers\Util::generateToken($usuario['mguid']);
                    $this->_getUsuarioService()->getRepository()->save(array(
                        'codigo_activar' => $codigoRecuperar
                    ), $usuario['id']);
                    
                    $serviceLocator = $this->getServiceLocator();
                    $email = new \Usuario\Model\Email\RecuperarPassword($serviceLocator);
                    $data['codigo_activar'] = $codigoRecuperar;
                    $ok = $email->sendMail($data);
                    if ($ok) {
                        $message = '<b>Felicidades, ya estás a punto de ser parte de Coney Club.</b> '
                            . 'Te hemos enviado un correo con las instrucciones para actualizar tu cuenta';
                        $this->flashMessenger()->addMessage(array(
                            'success' => $message,
                        ));
                        return $this->redirect()->toRoute('web-notificar');
                    } else {
                        $errorSend = 'Error al eviar correo electrónico.';
                        $form->get('email')->setMessages(array('errorSend' => $errorSend));
                    }
                } else {
                    $form->get('email')->setMessages(array('existsEmail' => $noExistsEmail));
                }
            }
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    public function modificarPasswordAction()
    {
        $codigo = $this->params('codigo', null);
        $form = $this->_getModificarPasswordForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-modificar-password', array(
            'controller' => 'registro',
            'action' => 'modificar-password',
        )));
        $form->get('codigo')->setValue($codigo);
        
        if ($this->request->isPost()) {
            $form->setInputFilter(new \Application\Filter\ModificarPasswordFilter());
            $data = $this->request->getPost()->toArray();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repository = $this->_getUsuarioService()->getRepository();
                $criteria = array('where' => array('codigo_activar' => $data['codigo']));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $dataIn = array(
                        'password' => \Common\Helpers\Util::passwordEncrypt($data['password'], $row['email']),
                        'codigo_activar' => null,
                    );
                    $repository->save($dataIn, $row['id']);
                    //modificar password en True-Fi
                }
            }
        }
        
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }

    private function _getDataRegistroTemp($campo)
    {
        $session = new \Zend\Session\Container('session_usuario');
        $regTemp = $session->offsetGet('temp_registro');
        if (!empty($regTemp)) {
            return isset($regTemp[$campo]) ? $regTemp[$campo] : null;
        }
        return null;
    }
    
    private function _removeDataRegistroTemp()
    {
        $session = new \Zend\Session\Container('session_usuario');
        $session->offsetUnset('temp_registro');
    }
    
    private function _getRegistroForm()
    {
        return $this->getServiceLocator()->get('Application\Form\RegistroForm');
    }
    
    private function _getRecuperarPasswordForm()
    {
        return $this->getServiceLocator()->get('Application\Form\RecuperarPasswordForm');
    }
    
    private function _getModificarPasswordForm()
    {
        return $this->getServiceLocator()->get('Application\Form\ModificarPasswordForm');
    }
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    protected function _getUbigeoService()
    {
        return $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
    }
}
