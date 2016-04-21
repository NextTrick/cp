<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class MisRecargasController extends SecurityWebController
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
    
    public function asociarNuevaTarjetaAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        if ($this->request->isPost()) {
            $result = array(
                'succes' => true,
            );
            
            echo json_encode($result);
            exit;
        }
        
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
    
    private function _getUsuarioService()
    {
        return $this->getServiceLocator()->get('Usuario\Model\Service\UsuarioService');
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }
}
