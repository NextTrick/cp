<?php

namespace Authentication\Controller;

use Zend\Session\Container;
use Authentication\Controller\AccessController;

class TwitterController extends AccessController
{
    public function loginAction()
    {       
        $consumer = $this->_getConsumerService();
        $twitterSes = new Container('twitter');
        
//        if (empty($twitterSes->requestToken)) {            
            $requestToken = $consumer->getRequestToken();        
            $twitterSes->requestToken = serialize($requestToken);
//        }
                
        $consumer->redirect();
    }
    
    public function callbackAction()
    {
        //var_dump($this->getServiceLocator()->get('twitterConnect')->getUserData()); exit; 
                        
        $consumer = $this->_getConsumerService();
        $twitterSes = new Container('twitter');        
        $requestToken = unserialize($twitterSes->requestToken);
        
        try {
            $accessToken = $consumer->getAccessToken($this->params()->fromQuery(), $requestToken); 
            $twitterSes->accessToken = serialize($accessToken);
            unset($twitterSes->requestToken);

            $twitter = $this->_getTwitterService();
            $httpClient = $accessToken->getHttpClient($this->_getConfig());
            $httpConfig = array(
                'adapter' => 'Zend\Http\Client\Adapter\Socket',
                'sslverifypeer' => false
            );
            $httpClient->setOptions($httpConfig);        
            $twitter->setHttpClient($httpClient);

            $this->_getTwitterService()->login($accessToken);
        
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
        
    protected function _getConfig()
    {
        $config = $this->getServiceLocator()->get('config');
        return $config['auth']['twitter'];
    }
               
    /**
     * 
     * @return \ZendOAuthentication\Consumer
     */
    protected function _getConsumerService()
    {        
        return $this->getServiceLocator()->get('Authentication\Model\Service\ConsumerService')->setTwitterConfig();
    }
    
    /**
     * 
     * @return \Authentication\Model\Service\TwitterService
     */
    protected function _getTwitterService()
    {
        return $this->getServiceLocator()->get('Authentication\Model\Service\TwitterService');
    }
}