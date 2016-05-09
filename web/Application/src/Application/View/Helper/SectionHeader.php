<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Abril 2016
 * Descripción :
 *
 */

namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionHeader extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke()
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $data = $sl->get('Usuario\Model\Service\LoginGatewayService')->getData();
        
        return $this->getView()->render('helper/section-header.phtml', array('data' => $data));
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}