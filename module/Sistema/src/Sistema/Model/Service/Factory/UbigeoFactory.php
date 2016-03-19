<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Sistema\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Sistema\Model\Service\UbigeoService;
use Sistema\Model\Repository\UbigeoRepository;

class UbigeoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new UbigeoRepository($adapter);

        return new UbigeoService($repository, $serviceLocator);
    }
}
