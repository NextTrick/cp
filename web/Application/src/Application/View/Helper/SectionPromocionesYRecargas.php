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

class SectionPromocionesYRecargas extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($cartModel, $tarjetaProductos)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $config = $sl->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }
        
        $rowsTarjetaProductos = array();
        foreach ($tarjetaProductos as $producto) {
            $rowsTarjetaProductos[$producto->getProductId()] = $producto;
        }
        
        $rowPromociones = $sl->get('Paquete\Model\Service\PaqueteService')->recargaPromociones();
        $rowRecargas = $sl->get('Paquete\Model\Service\PaqueteService')->recargaRecargas();
        return $this->getView()->render('helper/section-promociones-y-recargas.phtml', array(
            'rowPromociones' => $rowPromociones,
            'rowRecargas' => $rowRecargas,
            'cartModel' => $cartModel,
            'tarjetaProductos' => $rowsTarjetaProductos,
            'urlImg' => $config['fileDir']['paquete_paquete']['down'],
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