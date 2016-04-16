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
use Orden\Model\Service\OrdenService;
use Orden\Model\Repository\OrdenRepository;

class OrdenFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new OrdenRepository($adapter);

        return new OrdenService($repository, $serviceLocator);
    }
}
