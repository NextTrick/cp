<?php

namespace Application\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\SecurityWebController;

class LoginController extends SecurityWebController
{
    public function indexAction()
    {
        $form = $this->_getLoginForm();
        $form->setAttribute('action', $this->url()->fromRoute('web-login/modalidad', array(
            'controller' => 'login',
            'action' => 'validate',
            'option' => 'form',
        )));
        return new ViewModel(array('form' => $form));
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
            $viewModel->setTemplate('application/login/index');
            return $viewModel;
        }

        $values = $form->getData();
        $email = $values['email'];
        $password = $values['password'];

        $result = $this->_getLoginGatewayService()
                ->setGateway($opcion)
                ->setCredential($email, $password)
                ->login();

        if ($result->error === false) {
            return $this->_toUrlMain();
        } else {
            $this->flashMessenger()->addMessage(array('error' => $result->mesagge));
            return $this->_toUrlLogin();
        }
    }

    public function callbackAction()
    {
        try {
            $opcion = $this->params('opcion');
            $data = $this->_getLoginGatewayService()->setGateway($opcion)->callback();
            var_dump($data);exit;
            if ($data !== false) {
                $this->redirect()->toRoute('web-panel/inbox', array('controller' => 'tarjeta'));
            } else {
                $this->redirect()->toRoute('web-login/modalidad', array('controller' => 'login'));
            }
        } catch (\Exception $e) {
            $this->redirect()->toRoute('web-login/modalidad', array('controller' => 'login'));
        }
    }
    
    public function logoutAction()
    {
        $this->_getLoginGatewayService()->logout();
    }
    
    private function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Application\Form\LoginForm');
    }
}