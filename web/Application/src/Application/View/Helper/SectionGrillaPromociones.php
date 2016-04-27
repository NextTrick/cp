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

class SectionGrillaPromociones extends AbstractHelper implements ServiceLocatorAwareInterface
{
    public function __invoke($cantidad, $destacado, $page)
    {
        $sl = $this->getServiceLocator()->getServiceLocator();
        $config = $sl->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }
        
        $rows = $sl->get('Paquete\Model\Service\PaqueteService')->grillaPromociones($cantidad, $destacado);
        return $this->getView()->render('helper/section-grilla-promociones/' . $page . '.phtml', array(
            'rows' => $rows,
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