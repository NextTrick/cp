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
use Admin\Model\Service\DetalleOrdenService;
use Admin\Model\Repository\DetalleOrdenRepository;

class DetalleOrdenFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new DetalleOrdenRepository($adapter);

        return new DetalleOrdenService($repository, $serviceLocator);
    }
}
