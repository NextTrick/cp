<?php
/**
 * Created by PhpStorm.
 * User: diomedes
 * Date: 19/04/16
 * Time: 10:12 PM
 */

namespace Orden\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Orden\Form\BuscarForm;


class BuscarFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new BuscarForm($serviceLocator);
    }
}