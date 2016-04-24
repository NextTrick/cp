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
        $view = new ViewModel();
        return $view;
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
