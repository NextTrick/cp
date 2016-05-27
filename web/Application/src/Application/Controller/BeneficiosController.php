<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class BeneficiosController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }
        
        $rows = $this->_getPaqueteService()->grillaBeneficios(GRID_PROMOCIONES_Y_RECARGAS, 1);
        
        $view = new ViewModel();
        $view->setVariable('rows', $rows);
        $view->setVariable('urlImg', $config['fileDir']['paquete_paquete']['down']);
        return $view;
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
