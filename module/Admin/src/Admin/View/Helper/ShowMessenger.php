<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Diciembre 2015
 * Descripción :
 *
 */

namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ShowMessenger extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($flashMessage)
    {
        //$sl = $this->getServiceLocator()->getServiceLocator();
        
        return $this->getView()->render('helper/show-messenger.phtml',
                array('flashMessage' => $flashMessage));
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}