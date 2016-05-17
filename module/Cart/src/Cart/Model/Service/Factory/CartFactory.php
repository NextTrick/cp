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
        $config = $serviceLocator->get('config');
        $config = isset($config['cart']) ? $config['cart'] : array();
        $defultConfig = array(
            'amount_decimal_length' => 2,
            'amount_decimal_separator' => '.',
            'amount_thousands_separator' => ',',
            'quantity_max_by_product' => 5,
            'currency' => 'NS',
        );
        $config = array_merge($config, $defultConfig);

        return new CartService($serviceLocator, $config);
    }
}
