<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Cms\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cms\Model\Service\ContenidoService;
use Cms\Model\Repository\ContenidoRepository;

class ContenidoFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $adapter    = $serviceLocator->get('dbAdapter');
        $repository = new ContenidoRepository($adapter);

        return new ContenidoService($repository, $serviceLocator);
    }
}
