<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
        $view = new ViewModel();
        return $view;
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
        $oauth = $this->_getOauthCallbackService();
        
        $oauth->callback();
        echo 't';exit;
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
