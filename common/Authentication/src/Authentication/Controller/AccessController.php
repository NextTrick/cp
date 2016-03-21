<?php

namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Authentication\Form\LoginForm;
use Authentication\Filter\LoginFilter;
use Authentication\Form\RecoverForm;
use Authentication\Form\NewPasswordForm;
use Authentication\Filter\RecoverFilter;
use Authentication\Filter\NewPasswordFilter;
//use Auth\Entity\AuthRoles;
use Authentication\Model\Service\AclService;

class AccessController extends AbstractActionController
{       
    public $adminUri = '';
    
    public function logoutAction()
    {
        unset($_SESSION);
        session_unset();
        if (!$this->auth()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        $this->getAuthenticationService()->logout();
        
        return $this->redirect()->toRoute('home');
    }
    
    public function loginAction()
    {
        //$this->_redireccion();
        if($this->auth()->hasIdentity()) {
            return $this->redirect()->toRoute('admin-pagos');
        }
        $form = $this->_getLoginForm();
        $request = $this->getRequest();
        $flash = null;
                        
        if ($request->isPost()) {
            $form->setInputFilter($this->_getLoginFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
               if ($this->loginProcess($request)) {
                   $userData = $this->auth()->getIdentity();
                   $redirect = $form->get('redirect')->getValue();
                   
                   $rolRepository = $this->getRolService()->getRepository();
                   
                   if ($userData['rol_id'] == $rolRepository::ADMINISTRADOR_ID) {
                       $redirect = $this->adminUri;
                   }
                                      
                   if (!empty($redirect)) {
                       return $this->redirect()->toUrl($redirect);
                   }
                   
                   return $this->redirect()->toRoute('transacciones');
               } else {
                   $form->get('password')->setMessages(array('El correo o contraseña '
                       . 'ingresados son incorrectos'));
               }
            }
        } else {
            $redirect = $this->params()->fromQuery('redirect', null);
            if (!empty($redirect)) {
                $form->get('redirect')->setValue($redirect);
            }
        }

        $view = new ViewModel(array(
            'form'  => $form,
            'flash' => $flash,            
        ));        

        return $view;
    }
    
    public function newPasswordAction()
    {
        if($this->auth()->hasIdentity()) {
            return $this->redirect()->toRoute('admin-pagos');
        }
        $token = $this->params()->fromRoute('token', null);        
        if (empty($token)) {            
            echo 'Invalid route'; exit;            
        }
                
        $userService = $this->getUserService();
        $userData = $userService->getByTokenRecover($token);        
        if (empty($userData)) {
            echo 'Invalid Token';
            exit;
        } else { 
            if (!$userService->validTokenRecoverDate($userData['token_recover_creation_date'])) {
                echo 'Expired Token!';
                exit;
            }            
        }
        
        $request = $this->getRequest();                
       
        $form = new NewPasswordForm(); 
        $form->setAttribute('action', 'new-password/token/' . $token);
        if ($request->isPost()) {            
            $form->setInputFilter(new NewPasswordFilter());            
            $form->setData($request->getPost());            
            if ($form->isValid()) {
                $password = $form->get('password')->getValue();
                $password2 = $form->get('password2')->getValue();                 
                if ($password == $password2) {                     
                    $userService->updatePassword((array) $userData, $password);
                    $this->redirect()->toUrl('/login');
                } else {
                    $form->get('password2')->setMessages(array('Las contraseñas 
                        introducidas no coinciden. Vuelve a intentarlo'));
                }
            }
        }
        
        $view = new ViewModel(array(
            'form' => $form,            
            'token' => $token,            
        ));
        
        return $view;    
    }
    
    public function recoverAction()
    {
        if($this->auth()->hasIdentity()) {
            return $this->redirect()->toRoute('admin-pagos');
        }
        $form = new RecoverForm();
        $request = $this->getRequest();        
        $result = array(
            'success' => true,     
            'data' => array('status' => 0)
        );
        
        if ($request->isPost()) {
            $form->setInputFilter(new RecoverFilter());
            $form->setData($request->getPost());            
            if ($form->isValid()) {                
                $data = $form->getData();
                $result = $this->recoverProcess($data);
                if ($result['success'] == false) {
                    $form->get('email')->setMessages(array($result['data']['message']));
                } else {
                    $this->getAuthenticationService()->sendRecoverMail($data);
                }                
            }              
        }
        
        $view = new ViewModel();
        $view->form = $form;
        $view->viewData = $result;
        
        return $view;
    }
        
    private function recoverProcess($data)
    {        
        $authentication = $this->getAuthenticationService();        
        $result = $authentication->validRecover($data['email']);        
        
        return $result;
    }
    
    public function recoverFilter()
    {
        $recoverFilter = new RecoverFilter();
        $recoverFilter->init();
        
        return $recoverFilter();
    }
    
    public function accessDeniedAction()
    {
        echo 'Access Denied!!'; exit;
    }   
            
    private function loginProcess($request)
    {
        $authentication = $this->getAuthenticationService();
                
        $authData = array(
            $authentication->getIdentityColumn() => $request->getPost('email'),
            $authentication->getCredentialColumn() => $request->getPost('password'),
        );        

        if ($authentication->authenticate($authData)) {
            return true;
        }

        return false;
    }        
    
    private function _getLoginForm()
    {
        return new LoginForm();
    }
    
    /**
     * 
     * @return \Authentication\Model\Service\AuthenticationService
     */
    protected function getAuthenticationService()
    {
       return $this->getServiceLocator()->get('Authentication\Model\Service\AuthenticationService') ;
    }     
    
    private function _redireccion()
    {        
        if ($this->auth()->getUsuario()) {
            $authService = $this->getAuthenticationService();
                        
            $redireccion = $authService->getRedireccion();                              
            return $this->redirect()->toRoute($redireccion);
        }        
    }
    
    private function _getLoginFilter()
    {
        $loginFilter = new LoginFilter(); 
        $loginFilter->init();
        
        return $loginFilter;
    }
    
    public function getUserService()
    {
        return $this->getServiceLocator()->get(AclService::SERVICE_USER);
    }
     
    public function getRolService()
    {
        return $this->getServiceLocator()->get(AclService::SERVICE_ROL);
    }
}