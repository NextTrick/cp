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
            'type' => 'general',
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
                    'type' => 'campos_vacios',
                    'message' => 'Ingrese el nombre y el número.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            $existe = $this->_validateNombre($nombre, $numero);
            if ($existe) {
                $result = array(
                    'success' => false,
                    'type' => 'existe_nombre',
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
            $result['type'] = 'proceso';
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function editarNombreAction()
    {
        $response = $this->getResponse();
        
        $result = array(
            'success' => false,
            'type' => 'validacion',
            'message' => 'Error, intentelo nuevamente.'
        );
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        if ($this->request->isPost()) {
            $usuario = $this->_getUsuarioData();
            $numero = $this->request->getPost('numero');
            $nombre = $this->request->getPost('nombre');
            $existe = $this->_validateNombre($nombre, $numero);
            if (empty($nombre)) {
                $result = array(
                    'success' => false,
                    'type' => 'validacion',
                    'message' => 'Asigne un nombre a la tarjeta.'
                );
                $jsonModel =  new \Zend\View\Model\JsonModel($result);
                return $response->setContent($jsonModel->serialize());
            }
            
            if ($existe) {
                $result = array(
                    'success' => false,
                    'type' => 'validacion',
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
                    $this->_getTarjetaService()->cronTarjetas($row['cguid']);
                    $result['success'] = true;
                    $result['type'] = 'proceso';
                    $result['message'] = null;
                }
            } else {
                $result['type'] = 'proceso';
                $result['message'] = 'La tarjeta no se encuentra registrada.';
            }
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function tarjetaUnidadAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        $cguid = $this->request->getQuery('cguid');
        $index = $this->request->getQuery('index');
        $codigo = $this->request->getQuery('codigo');
        $nombre = $this->request->getQuery('nombre');
        $numero = $this->request->getQuery('numero');
        $destino = $this->request->getQuery('destino');

        $tarjetaId = \Common\Helpers\Crypto::decrypt($codigo, \Common\Helpers\Util::VI_ENCODEID);
        $row = $this->_getTarjetaService()->getRepository()->findOne(array('where' => array('id' => $tarjetaId)));
        
        if (!empty($row)) {
            $actualizo = false;
            if (empty($row['fecha_actualizacion'])) {
                $this->_getTarjetaService()->cronTarjetas($cguid);
                $actualizo = true;
            } else {
                $restarTiempo = $this->_getTarjetaService()->getRestarTiempo();
                $tsActual = strtotime(date('Y-m-d H:i:s', $restarTiempo));
                $tsRow = strtotime($row['fecha_actualizacion']);
                if ($tsRow < $tsActual) {
                    $this->_getTarjetaService()->cronTarjetas($cguid);
                    $actualizo = true;
                }
            }
            if ($actualizo) {
                $row = $this->_getTarjetaService()->getRepository()->findOne(array('where' => array('id' => $tarjetaId)));
            }
        }

        $row['nombre'] = $nombre;
        $row['numero'] = $numero;
        $row['codigo'] = $codigo;
        
        $view = new ViewModel();
        $view->setTemplate('mis-tarjetas/tarjeta-unidad');
        $view->setTerminal(true);
        $view->setVariable('index', $index);
        $view->setVariable('row', $row);
        
        $resolver = new \Zend\View\Resolver\TemplatePathStack(array(
            'script_paths' => array(dirname(dirname(dirname(__DIR__))) . '/view/application/')
        )); 
        $renderer = new \Zend\View\Renderer\PhpRenderer();
        $renderer->setResolver($resolver);
        $viewHtml = $renderer->render($view);
        
        $result['success'] = true;
        $result['message'] = null;
        $result['data'] = array('html' => $viewHtml, 'destino' => $destino);

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
