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
use Orden\Model\Service\CarritoService;
use Orden\Model\Repository\CarritoRepository;

class CarritoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new CarritoRepository($adapter);

        return new CarritoService($repository, $serviceLocator);
    }
}
