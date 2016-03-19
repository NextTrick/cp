<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Usuario\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Usuario\Model\Service\PerfilPagoService;
use Usuario\Model\Repository\PerfilPagoRepository;

class PerfilPagoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new PerfilPagoRepository($adapter);

        return new PerfilPagoService($repository, $serviceLocator);
    }
}
