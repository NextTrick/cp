<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegistroController extends AbstractActionController
{
    public function indexAction()
    {
        if ($this->_getLoginGatewayService()->isLoggedIn()) {
            return $this->redirect()->toRoute('web-beneficios', array('controller' => 'beneficios'));
        }
        
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
        
        $registroForm = (float)$this->request->getPost('registro_form');
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
        } elseif ($registroForm) {
            $this->flashMessenger()->addMessage(array('error' => 'Este campo es requerido y no puede estar vacío.'));
            return $this->redirect()->toRoute('web-registro', array('controller' => 'registro'));
        }

        $mensajeRegistro = null;
        $openPopapConfRegistro = 0;
        if ($this->request->isPost() && !$registroForm) {
            //==================== Llenar los combos ===========================
            $departamentoId = $this->request->getPost('departamento_id');
            $provinciaId = $this->request->getPost('provincia_id');
            $departamentos = $this->_getUbigeoService()->getPeDepartamentos();
            $form->get('departamento_id')->setValueOptions($departamentos);
            $provincias = $this->_getUbigeoService()->getProvincias($departamentoId);
            $form->get('provincia_id')->setValueOptions($provincias);
            $distritos = $this->_getUbigeoService()->getDistritos($provinciaId);
            $form->get('distrito_id')->setValueOptions($distritos);
            //==================== Fin llenar los combos =======================
            
            //====================== Aplicar filter ============================
            $form->setInputFilter(new \Application\Filter\RegistroFilter());
            $data = $this->request->getPost();
            
            $form->setData($data);
            //====================== Fin Aplicar filter ========================
            
            //======================== Validar fecha ===========================
            $fechaValida = false;
            $fechaNac = null;
            if (\Common\Helpers\Util::checkDate($data['mes'], $data['dia'], $data['anio'])) {
                $fechaValida = true;
                $fechaNac = $data['anio'] . '-' . $data['mes'] . '-' . $data['dia'];
            } else {
                $form->get('dia')->setMessages(array('noValido' => 'El campo fecha no es válido.'));
            }
            //======================== Fin validar fecha =======================

            if ($form->isValid() && $fechaValida) {
                $data = $form->getData();
                $data['fecha_nac'] = $fechaNac;

                $repository = $this->_getUsuarioService()->getRepository();
                //verificar en base de datos
                $criteria = array('where' => array('email' => $data['email']));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $form->get('email')->setMessages(array('existsEmail' => $messageExistsEmail));
                } else {
                    $saveData = $this->_saveData($data);

                    $openPopapConfRegistro = 1;
                    $mensajeRegistro = 'Lo sentimos, no se pudo completar el proceso, por favor inténtelo más tarde.';
                    if ($saveData['success']) {
                        $mensajeRegistro = '<h3>¡Felicidades!, estás a punto de ser parte de Coney Club</h3>'
                            . '<p>Te hemos enviado un correo con las instrucciones para activar tu cuenta.</p>';
                    } elseif ($saveData['code'] == 'EXISTE_EMAIL') {
                        $openPopapConfRegistro = 0;
                        $mensajeRegistro = null;
                        $disabledEmail = false;
                        $form->get('email')->setMessages(array('existsEmail' => $messageExistsEmail));
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
        $result = array(
            'success' => false,
            'code' => 'ERROR_PROCESO',
        );
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
            try {
                $dataIn = array(
                    'email' => $data['email'],
                    'password' => \Common\Helpers\Util::passwordEncrypt($data['password'], $data['email']),
                    'mguid' => $resultTrueFi['mguid'],
                    //'codigo_activar' => \Common\Helpers\Util::generateToken($resultTrueFi['mguid']),
                    'nombres' => $data['nombres'],
                    'paterno' => $data['paterno'],
                    'materno' => $data['materno'],
                    'di_tipo' => $data['di_tipo'],
                    'di_valor' => $data['di_valor'],
                    'pais_id' => $this->_getUbigeoService()->getPePaisId(),
                    'departamento_id' => $data['departamento_id'],
                    'provincia_id' => $data['provincia_id'],
                    'distrito_id' => $data['distrito_id'],
                    'fecha_nac' => $data['fecha_nac'],
                    'fecha_creacion' => date('Y-m-d H:i:s'),
                    'estado' => 0,
                );

                $gateway = $this->_getDataRegistroTemp('gateway');   
                switch ($gateway) {
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_FACEBOOK:
                        $dataIn['facebook_id'] = $this->_getDataRegistroTemp('id');
                        $dataIn['estado'] = 1;
                        break;
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_TWITTER:
                        $dataIn['twitter_id'] = $this->_getDataRegistroTemp('id');
                        break;
                }

                $codigoRecuperar = \Common\Helpers\Util::generateToken($resultTrueFi['mguid']);
                $dataIn['codigo_activar'] = $codigoRecuperar;

                $usuarioId = $repository->save($dataIn);
                if ($usuarioId) {
                    //si es facebook activar cuenta en TrueFi
                    if ($dataIn['estado'] == 1 && !empty($dataIn['facebook_id'])) {
                        $this->_getUsuarioService()->activarEnTrueFi(array('MGUID' => $resultTrueFi['mguid']));
                    }

                    $result['success'] = true;
                    $result['code'] = null;

                    unset($data);
                    unset($dataIn);
                    unset($dataTrueFi);
                } else {
                    $result['code'] = 'ERROR_PROCESO';
                }
            } catch (\Exception $e) {
                \Util\Common\Email::reportException($e);
            }
        } else {
            \Util\Common\Email::reportDebug($resultTrueFi, null, 'Error completar registro');
            $result['code'] = 'EXISTE_EMAIL';
        }
        
        $this->_removeDataRegistroTemp();
        return $result;
    }
    
    public function activarCuentaAction()
    {
        $mguid = $this->request->getQuery('mguid');
        $repository = $this->_getUsuarioService()->getRepository();
        $criteria = array('where' => array('mguid' => $mguid));
        $row = $repository->findOne($criteria);
        if (!empty($row)) {
            //activar en True-Fi
            $this->_getUsuarioService()->activarEnTrueFi(array('MGUID' => $mguid));
            $this->_getUsuarioService()->getRepository()->save(array(
                'estado' => 1,
                'codigo_activar' => null,
            ), $row['id']);

            $result = $this->_getLoginGatewayService()->loginOffline($row['email']);
            if ($result['success']) {
                return $this->redirect()->toRoute('web-mis-tarjetas', array('controller' => 'mis-tarjetas'));
            }
        }

        return $this->redirect()->toRoute('web-login', array('controller' => 'login'));
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
            $result['message'] = ERROR_TOKEN;
            $jsonModel->setVariables($result);
            return $response->setContent($jsonModel->serialize());
        }
        
        $messageError = 'Lo sentimos, no se pudo completar el proceso, por favor inténtalo más tarde';
        if ($this->request->isPost()) {
            $email = $this->request->getPost('email');
            $validator2 = new \Zend\Validator\EmailAddress();
            if (!$validator2->isValid($email)) {
                $result['message'] = 'El campo es requerido y no puede estar vacío.';
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $dataTrueFi = array('EMail' => $email);
            $usuarioTrueFi = $this->_getUsuarioService()->recoverPasswordEnTrueFi($dataTrueFi);
            if ($usuarioTrueFi['success']) {
                $result['success'] = true;
                $result['message'] = null;
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            } else {
                $noRegistrado = (strpos($usuarioTrueFi['message'], 'encuentra') !== false 
                        && strpos($usuarioTrueFi['message'], 'registrado ') !== false);
                
                $result['message'] = $noRegistrado ? 'El correo ingresado no está registrado.' : $messageError;
                $jsonModel->setVariables($result);
                return $response->setContent($jsonModel->serialize());
            }
        }
        
        $result['message'] = $messageError;
        $jsonModel->setVariables($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    /*public function modificarPasswordAction()
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
                $result['message'] = ERROR_TOKEN;
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
    }*/

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
    
    /*private function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Application\Form\LoginForm');
    }*/
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    protected function _getUbigeoService()
    {
        return $this->getServiceLocator()->get('Sistema\Model\Service\UbigeoService');
    }
    
    protected function _getLoginGatewayService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\LoginGatewayService');
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }
}
