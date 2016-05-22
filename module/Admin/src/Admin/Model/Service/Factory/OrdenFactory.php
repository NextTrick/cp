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
use Admin\Model\Service\OrdenService;
use Admin\Model\Repository\OrdenRepository;

class OrdenFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter    = $serviceLocator->get('dbAdapter');
        $repository = new OrdenRepository($adapter);

        return new OrdenService($repository, $serviceLocator);
    }
}
