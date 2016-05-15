<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Admin\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Admin\Model\Service\PaqueteService;
use Admin\Model\Repository\PaqueteRepository;

class PaqueteFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter    = $serviceLocator->get('dbAdapter');
        $repository = new PaqueteRepository($adapter);

        return new PaqueteService($repository, $serviceLocator);
    }
}
