<?php

namespace Authentication\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface,
    Zend\ServiceManager\FactoryInterface;
use Authentication\Model\Service\ConsumerService;

class ConsumerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {       
        return new ConsumerService();
    }
}