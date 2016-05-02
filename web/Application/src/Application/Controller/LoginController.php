<?php

namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

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
}