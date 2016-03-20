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
use Usuario\Model\Service\OauthFacebookService;
use Usuario\Model\Repository\UsuarioRepository;

class OauthFacebookFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter = $serviceLocator->get('dbAdapter');
        $repository = new UsuarioRepository($adapter);

        return new OauthFacebookService($repository, $serviceLocator);
    }
}
