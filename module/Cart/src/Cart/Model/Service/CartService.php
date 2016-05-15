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
    protected $_config = array();

    public function __construct($serviceLocator, $config)
    {
        $this->_sl = $serviceLocator;
        $this->_config = $config;
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
    
    public function addCart($groupProduct, Product $product)
    {
        $keyCart = $this->getCodeCart();
        $cache = $this->getCacheCartService();
        $cartModel = $cache->getItem($keyCart);
        
        if (!($cartModel instanceof Cart)) {
            $cartModel = new Cart($this->_config);
        }
        
        $cartModel->setGroupProduct($groupProduct);
        $cartModel->setProducts($product);
        
        $cache->setItem($keyCart, $cartModel);
        $cartModel2 = $cache->getItem($keyCart);
        $cartModel2->setGroupProduct($groupProduct);
        if ($cartModel2 instanceof Cart) {
            return $cartModel2;
        }
        
        return null;
    }
    
    public function removeCart($groupProduct = null, $productId = null)
    {
        $keyCart = $this->getCodeCart();
        if (!empty($groupProduct)) {
            $cache = $this->getCacheCartService();
            $cartModel = $cache->getItem($keyCart);
            if ($cartModel instanceof Cart) {
                $cartModel->setGroupProduct($groupProduct);
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