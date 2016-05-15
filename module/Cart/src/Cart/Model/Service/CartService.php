<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Cart\Model\Service;

use Cart\Model\Entity\Product;
use Cart\Model\Entity\Cart;
use Zend\Session\Container;

class CartService
{
    protected $_sl = null;

    public function __construct($serviceLocator)
    {
        $this->_sl = $serviceLocator;
    }
    
    public function getCart()
    {
        $keyCart = $this->getCodeCart();
        $cache = $this->getCacheCartService();
        $results = $cache->getItem($keyCart);
        if (!empty($results)) {
            $cartModel = $results;
            if ($cartModel instanceof Cart) {
                return $cartModel;
            }
        }
        
        return null;
    }
    
    public function addCart($cardId, Product $product)
    {
        $cart = new Cart();
        $cart->setCardId($cardId);
        $cart->setProducts($product);
        
        $keyCart = $this->getCodeCart();
        $cache = $this->getCacheCartService();
        $cache->setItem($keyCart, $cart);

        $cartModel = $cache->getItem($keyCart);
        if ($cartModel instanceof Cart) {
            return $cartModel;
        }
        
        return null;
    }
    
    public function removeCart($cardId = null, $productId = null)
    {
        $keyCart = $this->getCodeCart();
        if (!empty($cardId)) {
            $cache = $this->getCacheCartService();
            $cartModel = $cache->getItem($keyCart);
            if ($cartModel instanceof Cart) {
                $cartModel->setCardId($cardId);
                $cartModel->removeProducts($productId);
                $cache->setItem($keyCart, $cartModel);
            }
        } else {
            $cache = $this->getCacheCartService();
            $cache->removeItem($keyCart);
            $this->removeCodeCart();
        }
    }
    
    public function getCodeCart()
    {
        $session = new Container('cart');
        if ($session->offsetExists('codeCart')) {
            return $session->offsetGet('codeCart');
        }
        $codeCart = 'cart-' . md5(microtime() . uniqid());
        $session->offsetSet('codeCart', $codeCart);
        
        return $session->offsetGet('codeCart');
    }
    
    public function removeCodeCart()
    {
        $session = new Container('cart');
        $session->offsetUnset('codeCart');
    }
    
    protected function getCacheCartService()
    {
        return $this->_sl->get('cacheCart');
    }
}