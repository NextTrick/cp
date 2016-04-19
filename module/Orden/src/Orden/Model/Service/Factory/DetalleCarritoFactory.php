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
use Orden\Model\Service\DetalleCarritoService;
use Orden\Model\Repository\DetalleCarritoRepository;

class DetalleCarritoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new DetalleCarritoRepository($adapter);

        return new DetalleCarritoService($repository, $serviceLocator);
    }
}
