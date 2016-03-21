<?php

namespace Authentication\Model\Service;

use ZendOAuthentication\Consumer as ZendConsumer;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ConsumerService extends ZendConsumer implements ServiceLocatorAwareInterface
{
    protected $_sl;
    
    public function __construct($options = null) 
    {     
        parent::__construct($options);
        
        $httpClient = new \Zend\Http\Client();
        $httpConfig = array(
            'adapter' => 'Zend\Http\Client\Adapter\Socket',
            'sslverifypeer' => false
        );
        $httpClient->setOptions($httpConfig);

        $this->setHttpClient($httpClient);                
    }
    
    /**
     * 
     * @return \Authentication\Model\Service\Consumer
     */
    public function setTwitterConfig()
    {
        $config = $this->_sl->get('config');
        $oAuthTwitterConfig = $config['auth']['twitter'];
        
        $this->_config->setOptions($oAuthTwitterConfig);
        
        return $this;
    }
    
    /**
     * 
     * @return \Authentication\Model\Service\Consumer
     */
    public function setFacebookConfig()
    {
       
    }
    
   /**
     * Get service locator
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface;
     */
    public function getServiceLocator()
    {
        return $this->_sl;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->_sl = $serviceLocator;
    }
}
