<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Marzo 2016
 * Descripción :
 *
 */

namespace Application\Form\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Application\Form\ModificarPasswordForm;

class ModificarPasswordFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new ModificarPasswordForm($serviceLocator);
    }
}
