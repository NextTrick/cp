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
     
        $registroForm = (float)$this->request->getPost('registro_form', 0);
        if ($this->request->isPost() && $registroForm) {
            $form->setInputFilter(new \Application\Filter\RegistroFilter());
            $data = $this->request->getPost();
            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $gateway = $this->_getDataRegistroTemp('gateway');
                switch ($gateway) {
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_FACEBOOK:
                        $data['facebook_id'] = $this->_getDataRegistroTemp('id');
                        break;
                    case \Usuario\Model\Service\LoginGatewayService::LOGIN_TWITTER:
                        $data['twitter_id'] = $this->_getDataRegistroTemp('id');
                        break;
                }
                
                $repository = $this->_getUsuarioService()->getRepository();
                $save = $repository->save($data);
                if ($save) {
                    $this->_removeDataRegistroTemp();
                }
            }
        }
        
        return new ViewModel(array('form' => $form));
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
