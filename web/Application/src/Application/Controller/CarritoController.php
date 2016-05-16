<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;
use Zend\View\Model\ViewModel;
use Common\Helpers\Util;
use Common\Helpers\Crypto;

class CarritoController extends SecurityWebController
{
    public function indexAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        $usuario = $this->_getUsuarioData();
        $cartModel = $this->_getCartService()->getCart();
        
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }

        $cattidades = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05');

        $usuarioTarjetas = $this->_getTarjetaService()->getTarjetas($usuario->id);
        
        $view = new ViewModel();
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('cattidades', $cattidades);
        $view->setVariable('usuarioTarjetas', $usuarioTarjetas);
        $view->setVariable('urlImg', $config['fileDir']['paquete_paquete']['down']);
        return $view;
    }

    public function modificarAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        if ($this->request->isPost()) {
            $productoId = $this->request->getPost('id');
            $cantidad = $this->request->getPost('cantidad');
            $tarjetaCode = $this->request->getPost('tarjeta');
            $oldTarjetaCode = $this->request->getPost('old_tarjeta');
            
            $criteria = array('where' => array('id' => $productoId));
            $paquete = $this->_getPaqueteService()->getRepository()->findOne($criteria);
            $tarjetaId = Crypto::decrypt($tarjetaCode, Util::VI_ENCODEID);
            $criteria2 = array('where' => array('id' => $tarjetaId));
            $tarjeta = $this->_getTarjetaService()->getRepository()->findOne($criteria2);
            if (!empty($paquete) && !empty($tarjeta)) {
                $producto = array(
                    'product_id' => $paquete['id'],
                    'product_name' => $paquete['titulo1'],
                    'product_name2' => $paquete['titulo2'],
                    'imagen' => $paquete['imagen'],
                    'quantity' => $cantidad,
                    'price' => $paquete['emoney'],
                    'category_code' => $tarjetaCode,
                    'category_nombre' => $tarjeta['nombre'],
                );
                
                if (empty($oldTarjetaCode)) {
                    //Reemplaza la cantidad a la tarjeta associada
                    $cartModel = $this->_getCartService()->addCart($tarjetaCode, $producto);
                } else {
                    //Adiciona la cantidad y remueve el producto asocciado a la tarjeta antigua
                    $cartModel = $this->_getCartService()->addCart($tarjetaCode, $producto, true);
                    $this->_getCartService()->removeCart($oldTarjetaCode);
                }
                
                if (!empty($cartModel)) {
                    $data = array(
                        'subtotal' => $cartModel->getAmountGroup(true),
                        'total' => $cartModel->getAmountCart(true),
                        'cantidad' => $cartModel->getQuantityGroup(),
                    );
                    
                    $result = array(
                        'success' => true,
                        'message' => null,
                        'data' => $data,
                    );
                }
            }
        }
        
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function eliminarAction()
    {
        $response = $this->getResponse();
        $result = array('success' => false, 'message' => ERROR_VALIDACION);
        
        if ($this->_isLogin() === false) {
            $result['message'] = ERROR_303;
            $jsonModel =  new \Zend\View\Model\JsonModel($result);
            return $response->setContent($jsonModel->serialize());
        }

        if ($this->request->isPost()) {
            $productoId = $this->request->getPost('id');
            $tarjetaCode = $this->request->getPost('tarjeta');
            
            if (!empty($productoId) && !empty($tarjetaCode)) {
                $success = $this->_getCartService()->removeCart($tarjetaCode, $productoId);
                if ($success) {
                    $result = array(
                        'success' => true,
                        'message' => null,
                    );
                }
            }
        }

        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    public function pagosAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }
        
        $cartModel = $this->_getCartService()->getCart();
        
        $config = $this->getServiceLocator()->get('config');
        if (!isset($config['fileDir']['paquete_paquete']['down'])) {
            throw new \Exception('No existe url configurada.');
        }

        if (empty($cartModel)) {
            return $this->redirect()->toRoute('web-carrito', array('controller' => 'index'));
        }
        $view = new ViewModel();
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('urlImg', $config['fileDir']['paquete_paquete']['down']);
        return $view;
    }
    
    private function _getCartService()
    {
        return $this->getServiceLocator()->get('Cart\Model\Service\CartService');
    }
    
    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }
}
