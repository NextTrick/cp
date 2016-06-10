<?php

namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Cart\Model\Service\CartService;
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

        $messageError = 'Lo sentimos, no se pudo completar el proceso, por favor inténtalo más tarde';
        $result = new \stdClass();
        $result->error = true;
        $result->message = $messageError;
        
        //validar en TrueFi y registrar cuenta
        $usuarioWs = $this->_getUsuarioService()->logonEnTrueFi(array(
            'EMail' => $email,
            'Password' => $password,
        ));

        if ($usuarioWs['success']) {
            $usuarioBd = $this->_getUsuarioService()->getRepository()->findOne(array(
                'where' => array('email' => $email),
            ));
            
            if (!empty($usuarioBd)) {
                $this->_getUsuarioService()->modificarPasswordEnDb($usuarioBd['id'], $email, $password);
                
                $data = $this->_getLoginGatewayService()->loginOffline($email);
                if ($data['success']) {
                    $result->error = false;
                    $result->message = null;
                } else {
                    $result->error = true;
                    $result->message = $data['message'];
                }
            } else {
                $mguid = $usuarioWs['mguid'];
                $success = $this->_getUsuarioService()->registrarUsuarioDesdeTrueFi($mguid, $password);
                if ($success) {
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
            }
        } else {
            $noActivo = (strpos($usuarioWs['message'], 'Cliente') !== false 
                    && strpos($usuarioWs['message'], 'activo') !== false);
            $noRegistrado = (strpos($usuarioWs['message'], 'registrado') !== false 
                    && strpos($usuarioWs['message'], 'incorrecta') !== false);
            if ($noActivo) {
                $messageError = 'El usuario no se encuentra activado.';
            }
            if ($noRegistrado) {
                $messageError = 'Los datos ingresados son incorrectos.';
            }
            
            $result->error = true;
            $result->message = $messageError;
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
        $this->_getCartService()->removeCart();

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

    /**
     * @return CartService;
     */
    private function _getCartService()
    {
        return $this->getServiceLocator()->get('Cart\Model\Service\CartService');
    }
}