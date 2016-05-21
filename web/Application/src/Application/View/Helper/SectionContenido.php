<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Application\View\Helper;
use Zend\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class SectionContenido extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($codigo)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $contenido = $sl->get('Cms\Model\Service\ContenidoService')->getContenido($codigo);
        return $this->getView()->render('helper/section-contenido.phtml', array(
            'contenido' => $contenido,
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