<?php

namespace Authentication\Controller;

use Authentication\Controller\AccessController;

class FacebookController extends AccessController
{
    public function loginAction()
    {       
        $redirect = $this->params()->fromQuery('redirect', null);
        
        $params = array();
        if (!empty($redirect)) {
            $params = array(
                'redirect' => $redirect,
            );
        }
        $facebook =  $this->_getFacebookService();
        
        return $this->redirect()->toUrl($facebook->getLoginUrl($params));                
    }
            
    public function callbackAction()
    {
        $redirect = $this->params()->fromQuery('redirect', null);   
        
        $facebook =  $this->_getFacebookService(); 
        $user = $facebook->getUser();        

        if (empty($user)) {
            return $this->redirect()->toUrl('/flogin');
        }
        
        try {
            $facebook->login();
            $userData = $this->auth()->getIdentity();
            if (empty($userData['email'])) {
                $this->redirect()->toUrl('/recover');
            }
        } catch(\Exception $e) {            
            \Util\Common\Email::reportException($e);            
        }
        
        if (!empty($redirect)) {
            return $this->redirect()->toUrl($redirect);    
        }
        
        return $this->redirect()->toRoute('home');    
    }
                
    /**
     * 
     * @return \Authentication\Model\Service\FacebookService
     */
    protected function _getFacebookService()
    {
        return $this->getServiceLocator()->get('Authentication\Model\Service\FacebookService');
    }
}