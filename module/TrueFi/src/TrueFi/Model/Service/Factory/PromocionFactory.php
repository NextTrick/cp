<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace TrueFi\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use TrueFi\Model\Service\PromocionService;

class PromocionFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new PromocionService($serviceLocator);
    }
}
