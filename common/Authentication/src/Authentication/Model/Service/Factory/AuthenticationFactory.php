<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\AuthenticationService;

class AuthenticationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {                 
        $adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');        
        return new AuthenticationService($adapter);
    }
}