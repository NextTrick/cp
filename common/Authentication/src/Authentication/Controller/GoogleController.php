<?php

namespace Authentication\Controller;

use Authentication\Controller\AccessController;
use Zend\Session\Container;

class GoogleController extends AccessController
{
    public function loginAction()
    {       
        $google =  $this->_getGoogleService();
        return $this->redirect()->toUrl($google->getLoginUrl());                
    }
            
    public function callbackAction()
    {        
        $google =  $this->_getGoogleService();      
        try {
     
            $google->login();
     
        } catch(\Exception $e) {
            $this->redirect()->toRoute('home');
        }        
 
        $currentUrlSes = new Container('currentUrl');         
        if (isset($currentUrlSes->currentUrl) && !empty($currentUrlSes->currentUrl)) {
            $currentUrl = $currentUrlSes->currentUrl;
            unset($currentUrlSes->currentUrl);
            $this->redirect()->toUrl($currentUrl);
        } else {
            $this->redirect()->toRoute('home');
        }               
    
    } 
    
    public function ajaxLoginAction()
    {        
        $facebook =  $this->_getFacebookService();      
        try {
            $facebook->login();
            $success = true;
        } catch(\Exception $e) {
            $success = false;
        } 

        return new \Zend\View\Model\JsonModel(array(
            'success' => $success,
        ));    
        
    }
        
    
    /**
     * 
     * @return \Authentication\Model\Service\GoogleService
     */
    protected function _getGoogleService()
    {
        return $this->getServiceLocator()->get('Authentication\Model\Service\GoogleService');
    }
}