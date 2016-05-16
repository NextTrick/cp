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

class SectionCart extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($usuarioId, $tarjetaCodigo)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        
        $usuarioTarjetas = $sl->get('Tarjeta\Model\Service\TarjetaService')->getTarjetas($usuarioId);

        return $this->getView()->render('helper/section-cart.phtml', array(
            'usuarioTarjetas' => $usuarioTarjetas,
            'tarjetaCodigo' => $tarjetaCodigo,
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