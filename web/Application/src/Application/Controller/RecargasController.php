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

        $tarjetaCodigo = $this->params('codigo');
        $usuario = $this->_getUsuarioData();
        $usuarioTarjetas = $this->_getTarjetaService()->getDdlTarjetas($usuario->id);
        
        if (empty($usuarioTarjetas)) {
            return $this->redirect()->toRoute('web-mis-tarjetas', array('controller' => 'index'));
        }
        
        if (empty($tarjetaCodigo)) {
            foreach ($usuarioTarjetas as $key => $value) {
                $tarjetaCodigo = $key;
                break;
            }
        }
        
        $cartModel = $this->_getCartService()->getCart();
        if (!empty($cartModel)) {
            $cartModel->setGroupProduct($tarjetaCodigo);
        }
        
        
        
        $view = new ViewModel();
        $view->setVariable('cartModel', $cartModel);
        $view->setVariable('usuarioTarjetas', $usuarioTarjetas);
        $view->setVariable('tarjetaCodigo', $tarjetaCodigo);
        return $view;
    }
    
    private function _getTarjetaService()
    {
        return $this->getServiceLocator()->get('Tarjeta\Model\Service\TarjetaService');
    }
    
    private function _getCartService()
    {
        return $this->getServiceLocator()->get('Cart\Model\Service\CartService');
    }
}
