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

        $result = array(
            'success' => true,
            'message' => 'Error, intentelo nuevamente.'
        );
        
        $response = $this->getResponse();
        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $numero = $this->request->getPost('numero');
            $nombre = $this->request->getPost('nombre');
            
            if (empty($nombre) || empty($numero)) {
                $result = array(
                    'success' => false,
                    'message' => 'Ingrese el nombre y el número.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $existe = $this->_validateNombre($nombre, $numero);
            if ($existe) {
                $result = array(
                    'success' => false,
                    'message' => 'Ya existe el nombre.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $data = array(
                'usuario_id' => $usuario->id,
                'numero' => $numero,
                'nombre' => $nombre,
            );
            $result = $this->_getUsuarioService()->asociarTarjeta($data);
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function editarNombreAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        $result = array(
            'success' => false,
            'message' => 'Error, intentelo nuevamente.'
        );
        
        $response = $this->getResponse();
        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $numero = $this->request->getPost('numero');
            $nombre = $this->request->getPost('nombre');
            $existe = $this->_validateNombre($nombre, $numero);
            if (empty($nombre)) {
                $result = array(
                    'success' => false,
                    'message' => 'Asigne un nombre a la tarjeta.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            if ($existe) {
                $result = array(
                    'success' => false,
                    'message' => 'Ya existe el nombre.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $criteria = array('where' => array('usuario_id' => $usuario->id, 'numero' => $numero));
            $row = $this->_getTarjetaService()->getRepository()->findOne($criteria);
            if (!empty($row)) {
                $data = array(
                    'nombre' => $nombre,
                );
                $save = $this->_getTarjetaService()->getRepository()->save($data, $row['id']);
                if (!empty($save)) {
                    $result['success'] = true;
                    $result['message'] = null;
                }
            } else {
                $result['message'] = 'La tarjeta no se encuentra registrada.';
            }
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    private function _validateNombre($nombre, $numero)
    {
        $existe = false;
        $usuario = $this->_getUsuarioData();
        $criteria = array(
            'where' => array('usuario_id' => $usuario->id)
        );
        $rows = $this->_getTarjetaService()->getRepository()->findAll($criteria);
        foreach ($rows as $row) {
            if (mb_strtolower($row['nombre'], 'UTF-8') == mb_strtolower($nombre, 'UTF-8')
            && trim($numero) !== $row['numero']) {
                $existe = true;
                break;
            }
        }
        
        return $existe;
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
