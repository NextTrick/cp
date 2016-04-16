<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Orden\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Orden\Model\Service\DetalleOrdenService;
use Orden\Model\Repository\DetalleOrdenRepository;

class DetalleOrdenFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new DetalleOrdenRepository($adapter);

        return new DetalleOrdenService($repository, $serviceLocator);
    }
}
