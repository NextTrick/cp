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
        
        $criteria = array(
            'like' => array(
                $usuario->id,
            ),
            'order' => 'fecha_creacion DESC',
        );
        $gridList = $this->_getTarjetaService()->getRepository()->findAll($criteria);
        $view = new ViewModel();
        $view->setVariable('gridList', $gridList);
        return $view;
    }

    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
