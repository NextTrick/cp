<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;

class MisTarjetasController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $usuario = $this->_getUsuarioData();
        $gridList = $this->_getTarjetaService()->misTarjetas($usuario->id);
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
            $usuario = $this->_getUsuarioData();
            $numero = $this->request->getPost('numero');
            $nombre = $this->request->getPost('nombre');
            
            $result = array(
                'success' => true,
                'message' => 'Ingrese el número y nombre.'
            );
            if (!empty($numero) && !empty($nombre)) {
                $data = array(
                    'usuario_id' => $usuario->id,
                    'numero' => $numero,
                    'nombre' => $nombre,
                );
                $result = $this->_getUsuarioService()->asociarTarjeta($data);
            }

            $response = $this->getResponse();
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
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
