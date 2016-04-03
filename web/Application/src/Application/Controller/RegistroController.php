<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class RegistroController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
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
        if ($this->request->isPost() && !$registroForm) {
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
                      
                $saveData = $this->_saveData($data);
                if ($saveData['success']) {
                    $message = '<b>Felicidades, ya estás a punto de ser parte de Coney Club.</b> '
                        . 'Te hemos enviado un correo con las instrucciones para activar tu cuenta';
                    $this->flashMessenger()->addMessage(array(
                        'success' => $message,
                    ));
                    return $this->redirect()->toRoute('web-notificar');
                } else {
                    $message = 'Lo sentimos, no se pudo completar el proceso, por favor inténtalo más tarde';
                    $this->flashMessenger()->addMessage(array(
                        'error' => $message,
                    ));
                    return $this->redirect()->toRoute('web-notificar');
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
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
        
        //verificar en base de datos
        $criteria = array('where' => array('email' => $data['email']));
        $row = $repository->findOne($criteria);
        
        $result = array('success' => false, 'message' => 'Error');
        if (!empty($row)) {
            $result['message'] = 'El correo ingresado ya fue registrado anteriormente.';
        } else {
            //registrar en True-Fi
            $resultTrueFi = $this->_getUsuarioService()->registrarEnTrueFi($dataTrueFi);
            if ($resultTrueFi['success']) {
                $save = $repository->save($data);
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
        }
        
        return $result;
    }
    
    public function notificarAction()
    {
        return new ViewModel();
    }
    
    public function confirmarAction()
    {
        return new ViewModel();
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
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
}
