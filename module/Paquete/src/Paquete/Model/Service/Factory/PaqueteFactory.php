<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Paquete\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Paquete\Model\Service\PaqueteService;
use Paquete\Model\Repository\PaqueteRepository;

class PaqueteFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new PaqueteRepository($adapter);

        return new PaqueteService($repository, $serviceLocator);
    }
}
