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
        $configAll = $serviceLocator->get('config');
        $config = isset($configAll['cart']) ? $configAll['cart'] : array();
        unset($configAll['cart']);

        return new CartService($serviceLocator, $config);
    }
}
