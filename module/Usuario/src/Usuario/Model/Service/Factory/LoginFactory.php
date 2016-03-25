<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Usuario\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Usuario\Model\Service\LoginService;
use Usuario\Model\Repository\UsuarioRepository;

class LoginFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new UsuarioRepository($adapter);

        return new LoginService($adapter, $repository, $serviceLocator);
    }
}