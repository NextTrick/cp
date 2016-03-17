<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Common\Controller\SecurityAdminController;

class LoginController extends SecurityAdminController
{

    public function indexAction()
    {
        $form = $this->_getLoginForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
            'controller' => 'login',
            'action' => 'validate'
        )));
        $this->layout('layout/login');
        return new ViewModel(array('form' => $form));
    }

    public function validateAction()
    {
        if (!$this->request->isPost()) {
            return $this->_toUrlLogin();
        }

        $form = $this->_getLoginForm();
        $form->setInputFilter(new \Admin\Filter\LoginFilter());
        $data = $this->request->getPost();
        $form->setData($data);
        if (!$form->isValid()) {
            $url = $this->url()->fromRoute('admin/crud', array(
                'controller' => 'login',
                'action' => 'validate',
            ));
            $form->setAttribute('action', $url);
            $this->layout('layout/login');
            $viewModel = new ViewModel(array('form' => $form));
            $viewModel->setTemplate('admin/login/index');
            return $viewModel;
        }

        $values = $form->getData();
        $username = $values['username'];
        $password = $values['password'];

        $result = $this->_getLoginService()->getRepository()
                ->login($username, $password)->getResultLogin();
        
        if ($result->error === false) {
            return $this->_toUrlMain();
        } else {
            $this->flashMessenger()->addMessage(array('error' => $result->mesagge));
            return $this->_toUrlLogin();
        }
    }

    public function logoutAction()
    {
        $this->_getLoginService()->getRepository()->logout();
        return $this->_toUrlLogin();
    }

    protected function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\LoginForm');
    }

    public function generateAction()
    {
        $password = $this->getRequest()->getQuery('password', null);
        $password1 = \Common\Helpers\Util::passwordEncrypt($password);
        var_dump($password1);
        exit;
    }
}