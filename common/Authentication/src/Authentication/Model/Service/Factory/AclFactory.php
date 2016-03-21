<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\AclService;

class AclFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {        
        $acl = new AclService();
        $acl->setServiceLocator($serviceLocator);
        $acl->begin();        
        return $acl;               
    }
}