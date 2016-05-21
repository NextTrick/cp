<?php

namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class LoginController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_getLoginGatewayService()->isLoggedIn()) {
            return $this->redirect()->toRoute('web-beneficios', array('controller' => 'beneficios'));
        }
        
        $form = $this->_getLoginForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-login/modalidad', array(
            'controller' => 'login',
            'action' => 'validate',
            'option' => 'form',
        )));
        $view = new ViewModel(array('form' => $form));
        $view->setVariable('openPopapChangePassword', 0);
        return $view;
    }
       
    public function validateSocialAction()
    {
        //Return in callback
        $opcion = $this->params('opcion');
        $this->_getLoginGatewayService()->setGateway($opcion)->login();
        exit();
    }
    
    public function validateAction()
    {
        if (!$this->request->isPost()) {
            return $this->_toUrlLogin();
        }

        $opcion = 'form';
        $form = $this->_getLoginForm();
        $form->setInputFilter(new \Application\Filter\LoginFilter());
        $data = $this->request->getPost();
        $form->setData($data);
        if (!$form->isValid()) {
            $url = $this->url()->fromRoute('web-login/modalidad', array(
                'controller' => 'login',
                'action' => 'validate',
            ));
            $form->setAttribute('action', $url);
            $viewModel = new ViewModel(array('form' => $form));
            $viewModel->setVariable('openPopapChangePassword', 0);
            $viewModel->setTemplate('application/login/index');
            return $viewModel;
        }

        $values = $form->getData();
        $email = $values['email'];
        $password = $values['password'];

        $usuarioBd = $this->_getUsuarioService()->getRepository()->findOne(array(
            'where' => array('email' => $email),
        ));

        $messageError = 'Lo sentimos, no se pudo completar el proceso, por favor inténtalo más tarde';
        
        $result = new \stdClass();
        $result->error = true;
        $result->message = $messageError;
        if (!empty($usuarioBd)) {
            $data = $this->_getLoginGatewayService()
                ->setGateway($opcion)
                ->setCredential($email, $password)
                ->login();
            $result->error = $data->error;
            $result->message = $data->message;
        } else {
            //validar en TrueFi y registrar cuenta
            $usuarioWs = $this->_getUsuarioService()->logonEnTrueFi(array(
                'EMail' => $email,
                'Password' => $password,
            ));

            if ($usuarioWs['success']) {
                $mguid = $usuarioWs['mguid'];
                $success = $this->_getUsuarioService()
                    ->registrarUsuarioDeTrueFi($mguid, $password);
                if ($success) {
                    //activar en True-Fi
                    $this->_getUsuarioService()->activarEnTrueFi(array('MGUID' => $mguid));
                    
                    $data = $this->_getLoginGatewayService()->loginOffline($email);
                    if ($data['success']) {
                        $result->error = false;
                        $result->message = null;
                    } else {
                        $result->error = true;
                        $result->message = $data['message'];
                    }
                } else {
                    $result->error = true;
                    $result->message = 'Los datos ingresados son incorrectos.';
                }
            } else {
                $noRegistrado = (strpos($usuarioWs['message'], 'registrado') !== false 
                        && strpos($usuarioWs['message'], 'incorrecta') !== false);

                $result->error = true;
                $result->message = $noRegistrado ? 'Los datos ingresados son incorrectos.' : $messageError;
            }
        }

        if ($result->error === false) {
            return $this->_toUrlMain();
        } else {
            $this->flashMessenger()->addMessage(array('error' => $result->message));
            return $this->_toUrlLogin();
        }
    }

    public function callbackAction()
    {
        try {
            $opcion = $this->params('opcion');
            $data = $this->_getLoginGatewayService()->setGateway($opcion)->callback();
            if (!empty($data) && $data['registrado'] === true) {
                return $this->redirect()->toRoute('web-beneficios', array('controller' => 'beneficios'));
            } else {
                return $this->redirect()->toRoute('web-completa-tu-registro');
            }
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('web-login/modalidad', array('controller' => 'login'));
        }
    }
    
    public function logoutAction()
    {
        $this->_getLoginGatewayService()->logout();
        return $this->redirect()->toRoute('web-login', array('controller' => 'login'));
    }
    
    private function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Application\Form\LoginForm');
    }
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
}