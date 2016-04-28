<?php

namespace Orden\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Orden\Model\Service\RequestHistorialService;
use Orden\Model\Repository\RequestHistorialRepository;

class RequestHistorialFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new RequestHistorialRepository($adapter);

        return new RequestHistorialService($repository, $serviceLocator);
    }
}
