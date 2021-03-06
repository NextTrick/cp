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
            $this->flashMessenger()->addMessage(array('error' => $result->message));
            return $this->_toUrlLogin();
        }
    }

    public function recuperarPasswordAction()
    {
        $form = $this->_getRecuperarPasswordForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
            'controller' => 'login',
            'action' => 'recuperar-password',
        )));
        
        if ($this->request->isPost()) {
            $form->setInputFilter(new \Admin\Filter\RecuperarPasswordFilter());
            $data = $this->request->getPost()->toArray();
            $form->setData($data);
            
            $criteria = array('where' => array('email' => $data['email']));
            $usuario = $this->_getUsuarioService()->getRepository()->findOne($criteria);

            $noExistsEmail = 'El correo electrónico no se ecuentra registrado.';
            if (empty($usuario)) {
                $form->get('email')->setMessages(array('noExistsEmail' => $noExistsEmail));
            } elseif ($form->isValid()) {
                //generar y guardar token de verificación
                $codigoRecuperar = \Common\Helpers\Util::generateToken($usuario['id']);
                $this->_getUsuarioService()->getRepository()->save(array(
                    'codigo_activar' => $codigoRecuperar
                ), $usuario['id']);

                $serviceLocator = $this->getServiceLocator();
                $email = new \Admin\Model\Email\RecuperarPassword($serviceLocator);
                $dataEmail = array(
                    'email' => $usuario['email'],
                    'nombres_completo' => $usuario['email'],
                    'codigo_activar' => $codigoRecuperar,
                );
                $ok = $email->sendMail($dataEmail);
                if ($ok) {
                    $message = 'Te hemos enviado un correo con las instrucciones para actualizar tu cuenta';
                    $this->flashMessenger()->addMessage(array(
                        'success' => $message,
                    ));
                } else {
                    $errorSend = 'Error al eviar correo electrónico.';
                    $this->flashMessenger()->addMessage(array(
                        'error' => $errorSend,
                    ));
                }
                return $this->redirect()->toRoute('admin/crud', array(
                    'controller' => 'login',
                    'action' => 'recuperar-password',
                ));
            }
        }
        
        $this->layout('layout/login');
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }

    public function modificarPasswordAction()
    {
        $codigo = $this->request->getQuery('codigo', null);
        $form = $this->_getModificarPasswordForm();
        $form->setAttribute('action', $this->url()->fromRoute('admin/crud', array(
            'controller' => 'login',
            'action' => 'modificar-password',
            'codigo' => $codigo,
        )));
        $form->get('codigo')->setValue($codigo);
        
        if ($this->request->isPost()) {
            $form->setInputFilter(new \Admin\Filter\ModificarPasswordFilter());
            $data = $this->request->getPost()->toArray();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $repository = $this->_getUsuarioService()->getRepository();
                $criteria = array('where' => array('codigo_activar' => $data['codigo']));
                $row = $repository->findOne($criteria);
                if (!empty($row)) {
                    $dataIn = array(
                        'password' => \Common\Helpers\Util::passwordHash($data['password']),
                        'codigo_activar' => null,
                    );
                    $repository->save($dataIn, $row['id']);
                    $this->flashMessenger()->addMessage(array(
                        'success' => 'Su password fué actualizada correctamente.',
                    ));
                    return $this->redirect()->toRoute('admin/crud', array(
                        'controller' => 'login',
                    ));
                } else {
                    $this->flashMessenger()->addMessage(array(
                        'error' => 'Error al actualizar su password.',
                    ));
                    return $this->redirect()->toRoute('admin-modificar-password', array(
                        'controller' => 'login',
                        'action' => 'modificar-password',
                        'codigo' => $codigo,
                    ));
                }
            }
        }
        
        $this->layout('layout/login');
        $view = new ViewModel();
        $view->setVariable('form', $form);
        return $view;
    }
    
    public function logoutAction()
    {
        $this->_getLoginService()->getRepository()->logout();
        return $this->_toUrlLogin();
    }
    
    private function _getRecuperarPasswordForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\RecuperarPasswordForm');
    }
    
    private function _getModificarPasswordForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\ModificarPasswordForm');
    }
    
    protected function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Admin\Model\Service\UsuarioService');
    }

    protected function _getLoginForm()
    {
        return $this->getServiceLocator()->get('Admin\Form\LoginForm');
    }

    public function generateAction()
    {
        $password = $this->getRequest()->getQuery('password', null);
        $password1 = \Common\Helpers\Util::passwordHash($password);
        var_dump($password1);
        exit;
    }
}