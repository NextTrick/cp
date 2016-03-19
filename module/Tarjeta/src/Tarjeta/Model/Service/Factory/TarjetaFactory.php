<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Tarjeta\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Tarjeta\Model\Service\TarjetaService;
use Tarjeta\Model\Repository\TarjetaRepository;

class TarjetaFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new TarjetaRepository($adapter);

        return new TarjetaService($repository, $serviceLocator);
    }
}
