<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $form = $this->_getLoginForm();
        $form->setAttribute('action', $this->url()->fromRoute('login-web/modalidad', array(
            'controller' => 'login',
            'action' => 'validate',
            'option' => 'form',
        )));
        return new ViewModel(array('form' => $form));
    }

    protected function _toUrlLogin()
    {
        return $this->redirect()->toRoute('login-web/modalidad', array('controller' => 'login'));
    }
    
    protected function _toUrlMain()
    {
        echo 'Mis tarjetas';
        exit;
        //return $this->redirect()->toRoute('login-web/modalidad', array('controller' => 'main'));
    }
    
    public function validateAction()
    {
        if (!$this->request->isPost()) {
            return $this->_toUrlLogin();
        }
        
        $opcion = $this->params('opcion', 'form');
        if (in_array($opcion, array('form'))) {
            $form = $this->_getLoginForm();
            $form->setInputFilter(new \Application\Filter\LoginFilter());
            $data = $this->request->getPost();
            $form->setData($data);
            if (!$form->isValid()) {
                $url = $this->url()->fromRoute('login-web/modalidad', array(
                    'controller' => 'login',
                    'action' => 'validate',
                ));
                $form->setAttribute('action', $url);
                $viewModel = new ViewModel(array('form' => $form));
                $viewModel->setTemplate('application/login/index');
                return $viewModel;
            }

            $values = $form->getData();
            $email = $values['email'];
            $password = $values['password'];

            $result = $this->_getLoginService()->login($email, $password)->getResultLogin();

            if ($result->error === false) {
                return $this->_toUrlMain();
            } else {
                $this->flashMessenger()->addMessage(array('error' => $result->mesagge));
                return $this->_toUrlLogin();
            }
        } else {
            throw new \Exception('Modalidad de validación incorrecta');
        }
    }

    public function facebookAction()
    {
        $oauth = $this->_getOauthFacebookService();
        
        $oauth->login();
        
        echo 'f';exit;
    }
    
    public function facebookCallbackAction()
    {
        $oauth = $this->_getOauthFacebookService();
        $data = $oauth->callback();
        var_dump($data);
        exit;
    }
    
    public function twitterAction()
    {
        $oauth = $this->_getOauthTwitterService();
        
        $oauth->login();
        echo 't';exit;
    }
    
    public function twitterCallbackAction()
    {
        $oauth = $this->_getOauthTwitterService();
        
        $oauth->callback();
        echo 't';exit;
    }
    
    public function logoutAction()
    {
        $oauth1 = $this->_getLoginService();
        $oauth2 = $this->_getOauthFacebookService();
        $oauth3 = $this->_getOauthTwitterService();
        
        $oauth1->logout();
        $oauth2->logout();
        $oauth3->logout();
    }
    
    protected function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Application\Form\LoginForm');
    }
    
    protected function _getLoginService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\LoginService');
    }
    
    protected function _getOauthFacebookService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\OauthFacebookService');
    }
    
    protected function _getOauthTwitterService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\OauthTwitterService');
    }
}
