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

class SectionGrillaRecargas extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($cantidad, $page)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $rows = $sl->get('Paquete\Model\Service\PaqueteService')->grillaRecargas($cantidad);
        return $this->getView()->render('helper/section-grilla-recargas/' . $page . '.phtml', array(
            'rows' => $rows,
        ));
    }

    public function getServiceLocator() {
        return $this->_sl;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->_sl = $serviceLocator;
        return $this;
    }
}