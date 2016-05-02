<?php
/**
 * Created by PhpStorm.
 * User: diomedes
 * Date: 19/04/16
 * Time: 10:12 PM
 */

namespace Admin\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Admin\Form\DetalleOrdenBuscarForm ;


class DetalleOrdenBuscarFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new DetalleOrdenBuscarForm($serviceLocator);
    }
}