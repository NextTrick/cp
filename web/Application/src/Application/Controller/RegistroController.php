<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegistroController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        return $view;
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
        
        $disabledEmail = false;
        $messageExistsEmail = 'El correo ingresado ya fue registrado anteriormente.';
        if (!empty($dataIni['email'])) {
            $disabledEmail = true;
            //verificar en base de datos
            $criteria = array('where' => array('email' => $dataIni['email']));
            $repository = $this->_getUsuarioService()->getRepository();
            $row = $repository->findOne($criteria);
            if (!empty($row)) {
                $this->flashMessenger()->addMessage(array('error' => $messageExistsEmail));
                $this->flashMessenger()->setNamespace('data')->addMessage(array('email' => $dataIni['email']));
                return $this->redirect()->toRoute('web-registro', array('controller' => 'registro'));
            }
        }

        $mensajeRegistro = null;
        $openPopapConfRegistro = 0;
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
                    $messageExistsEmail = 'El correo ingresado ya fue registrado anteriormente.';
                    $form->get('email')->setMessages(array('existsEmail' => $messageExistsEmail));
                } else {
                    $saveData = $this->_saveData($data);

                    $openPopapConfRegistro = 1;
                    $mensajeRegistro = 'Lo sentimos, no se pudo completar el proceso, por favor inténtelo más tarde.';
                    if ($saveData['success']) {
                        $mensajeRegistro = '<h3>¡Felicidades!, estás a punto de ser parte de Coney Club</h3>'
                            . '<p>Te hemos enviado un correo con las instrucciones para activar tu cuenta.</p>';
                    }
                }
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'disabledEmail' => $disabledEmail,
            'mensajeRegistro' => $mensajeRegistro,
            'openPopapConfRegistro' => $openPopapConfRegistro,
        ));
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
    
//    public function notificarAction()
//    {
//        return new ViewModel();
//    }
    
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
        $result = array('success' => false, 'message' => null, 'token' => null);
        $response = $this->getResponse();
        $jsonModel =  new \Zend\View\Model\JsonModel();
        
        $token = $this->request->getPost('token');
        $validator1 = new \Zend\Validator\Csrf();
        $validator1->setName('token_csrf');
        $isValidToken = $validator1->isValid($token);
        $result['token'] = $validator1->getHash(true);
        
        if (!$isValidToken) {
            $result['message'] = 'Token invalido.';
            $jsonModel->setVariables($result);
            return $response->setContent($jsonModel->serialize());
        }
            
        if ($this->request->isPost()) {
            $email = $this->request->getPost('mail');
            $validator2 = new \Zend\Validator\EmailAddress();
            if (!$validator2->isValid($email)) {
                $result['message'] = 'Ingrese un email correcto.';
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $criteria = array('where' => array('email' => $email));
            $existe = $this->_getUsuarioService()->getRepository()->findExists($criteria);
            
            $usuarioTrueFi = array();
            if ($existe === false) {
                $dataTrueFi = array(
                    'EMail' => $email,
                );
                $usuarioTrueFi = $this->_getUsuarioService()->usuarioEnTrueFi($dataTrueFi);
                $existe = empty($usuarioTrueFi) ? false : true;
            }
            
            $noExistsEmail = 'El correo electrónico no se ecuentra registrado.';
            if ($existe === false) {
                $result['message'] = $noExistsEmail;
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            } else {
                if (!empty($usuarioTrueFi)) {
                    //registrar usuario en el sistema con datos devueltos de TrueFi
                }

                $criteria = array('where' => array('email' => $email));
                $usuario = $this->_getUsuarioService()->getRepository()->findOne($criteria);
                if (!empty($usuario)) {
                    //generar y guardar codigo de verificación
                    $codigoRecuperar = \Common\Helpers\Util::generateToken($usuario['mguid']);
                    $this->_getUsuarioService()->getRepository()->save(array(
                        'codigo_activar' => $codigoRecuperar
                    ), $usuario['id']);
                    
                    $serviceLocator = $this->getServiceLocator();
                    $email = new \Usuario\Model\Email\RecuperarPassword($serviceLocator);
                    $data['codigo_activar'] = $codigoRecuperar;
                    $ok = $email->sendMail($data);
                    if ($ok) {
                        $result['success'] = true;
                        $result['message'] = null;
                        $jsonModel->setVariables($result);
                        return $response->setContent($jsonModel->serialize());
                    } else {
                        $result['message'] = 'Error al eviar correo electrónico.';
                        $jsonModel->setVariables($result);
                        return $response->setContent($jsonModel->serialize());
                    }
                } else {
                    $result['message'] = $noExistsEmail;
                    $jsonModel->setVariables($result);
                    return $response->setContent($jsonModel->serialize());
                }
            }
        }
        
        $result['message'] = 'Ocurrio un error, por favor intentelo nuevamente.';
        $jsonModel->setVariables($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function modificarPasswordAction()
    {
        $codigo = $this->params('codigo', null);        
        if ($this->request->isPost()) {
            $result = array('success' => false, 'message' => null, 'token' => null);
            
            $response = $this->getResponse();
            $jsonModel =  new \Zend\View\Model\JsonModel();
            
            //validar y generar token
            $token = $this->request->getPost('token');
            $validator1 = new \Zend\Validator\Csrf(array('name' => 'token_csrf'));
            $isValidToken = $validator1->isValid($token);
            $result['token'] = $validator1->getHash(true);
            if (!$isValidToken) {
                $result['message'] = 'Token invalido.';
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            }
        
            //recuperar password y validar
            $password = $this->request->getPost('password');
            $passwordRepeat = $this->request->getPost('password_repeat');
            if (empty($password)) {
                $result['message'] = 'Ingrese contraseña por favor.';
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            } elseif ($passwordRepeat != $password) {
                $result['message'] = 'Las contraseñas ingresadas no coinciden.';
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            }

            //verificar el codigo de recuperacion
            $codigoRecuperacion = $this->request->getPost('codigo_recuperacion');
            if (!empty($codigoRecuperacion)) {
                $repository = $this->_getUsuarioService()->getRepository();
                $criteria = array('where' => array('codigo_activar' => $codigoRecuperacion));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $dataIn = array(
                        'password' => \Common\Helpers\Util::passwordEncrypt($password, $row['email']),
                        'codigo_activar' => null,
                    );
                    $repository->save($dataIn, $row['id']);
                    //modificar password en True-Fi
                    
                    $result['success'] = true;
                    $result['message'] = null;
                } else {
                    $result['message'] = 'El enlace que se envio a su correo '
                            . 'electrónico, ya vencio o ya fue usada.';
                }
            } else {
                $result['message'] = 'Por favor verifique su correo electrónico, '
                        . 'se le envio un enlace para modificar su contraseña.';
            }
            
            $jsonModel->setVariables($result);
            return $response->setContent($jsonModel->serialize());
        }

        $form = $this->_getLoginForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-login/modalidad', array(
            'controller' => 'login',
            'action' => 'validate',
            'option' => 'form',
        )));
        $view = new ViewModel(array('form' => $form));
        $view->setTemplate('application/login/index');
        $view->setVariable('openPopapChangePassword', 1);
        $view->setVariable('codigoRecuperacion', $codigo);
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
    
    private function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Application\Form\LoginForm');
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
