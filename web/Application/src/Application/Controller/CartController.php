<?php
namespace Application\Controller;

use Application\Controller\SecurityWebController;


class CartController extends SecurityWebController
{
    public function modificarAction()
    {
        if ($this->_isLogin() === false) {
            return $this->_toUrlLogin();
        }

        $result = array('success' => false);
        if ($this->request->isPost()) {
            $cantidad = $this->request->getPost('cantidad');
            $paqueteId = $this->request->getPost('id');
            $tarjetaCode = $this->request->getPost('tarjeta');
            $tarjetaId = \Common\Helpers\Crypto::decrypt($tarjetaCode, \Common\Helpers\Util::VI_ENCODEID);
            
            $criteria = array('where' => array('id' => $paqueteId));
            $paquete = $this->_getPaqueteService()->getRepository()->findOne($criteria);
            
            if (!empty($paquete)) {
                $product = new \Cart\Model\Entity\Product();
                $product->setProductId($paquete['id']);
                $product->getProductName($paquete['titulo1']);
                $product->getProductImage($paquete['imagen']);
                $product->setQuantity($cantidad);
                $product->setPrice($paquete['emoney']);
                $cartModel = $this->_getCartService()->addCart($tarjetaId, $product);
                if (!empty($cartModel)) {
                    $data = array(
                        'subtotal' => $cartModel->getAmountGroup(true),
                        'total' => $cartModel->getAmountCart(true),
                        'cantidad' => $cartModel->getQuantityGroup(),
                    );
                    
                    $result = array(
                        'success' => true,
                        'data' => $data,
                    );
                }
            }
        }
        
        $response = $this->getResponse();
        $jsonModel =  new \Zend\View\Model\JsonModel($result);
        return $response->setContent($jsonModel->serialize());
    }
    
    private function _getCartService()
    {
        return $this->getServiceLocator()->get('Cart\Model\Service\CartService');
    }
    
    private function _getPaqueteService()
    {
        return $this->getServiceLocator()->get('Paquete\Model\Service\PaqueteService');
    }
}
