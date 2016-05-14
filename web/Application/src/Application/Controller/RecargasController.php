<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class RecargasController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        $usuario = $this->_getUsuarioData();
        $usuarioTarjetas = $this->_getPaqueteService()->getCards($usuario->id);
        $view = new ViewModel();
        $view->setVariable('usuarioTarjetas', $usuarioTarjetas);
        return $view;
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
