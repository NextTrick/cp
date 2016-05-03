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
use Admin\Form\OrdenBuscarForm;


class OrdenBuscarFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new OrdenBuscarForm($serviceLocator);
    }
}