<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\GoogleService;

class GoogleFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {              
        $config = $serviceLocator->get('config');        
        return new GoogleService($config['google']); 
    }
}