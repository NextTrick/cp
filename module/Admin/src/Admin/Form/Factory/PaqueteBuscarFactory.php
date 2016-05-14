<?php
/**
 * Created by PhpStorm.
 * User: diomedes
 * Date: 19/04/16
 * Time: 10:12 PM
 */

namespace Admin\Form\Factory;

use TwitterOAuth\OAuth\Exception;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Admin\Form\PaqueteBuscarForm;


class PaqueteBuscarFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        try {
            return new PaqueteBuscarForm($serviceLocator);
        } catch (\Exception $e) {
            var_dump($e);exit;
        }
    }
}