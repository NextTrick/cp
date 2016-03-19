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
use Usuario\Model\Service\UsuarioService;
use Usuario\Model\Repository\UsuarioRepository;

class UsuarioFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new UsuarioRepository($adapter);

        return new UsuarioService($repository, $serviceLocator);
    }
}
