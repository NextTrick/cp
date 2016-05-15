<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Cart\Model\Service\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Cart\Model\Service\CartService;

class CartFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new CartService($serviceLocator);
    }
}
