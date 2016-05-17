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
    
    public function addCart($product, $groupProduct = 0, $adding = false)
    {
        $productModel = new Product($this->_config);
        $productModel->setProductId($product['product_id']);
        $productModel->setProductName($product['product_name']);
        $productModel->setProductName2($product['product_name2']);
        $productModel->setProductImage($product['imagen']);
        $productModel->setQuantity($product['quantity']);
        $productModel->setPrice($product['price']);
        $productModel->setCategoryCode($product['category_code']);
        $productModel->setCategoryName($product['category_nombre']);
        $productModel->setOptions($product['options']);
        
        $keyCart = $this->getCodeCart();
        $cache = $this->getCacheCartService();
        $cartModel = $cache->getItem($keyCart);
        
        if (!($cartModel instanceof Cart)) {
            $cartModel = new Cart($this->_config);
        }
        
        $cartModel->setGroupProduct($groupProduct);
        $cartModel->setProducts($productModel, $adding);
        
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
                
                $cantidad = $cartModel->getQuantityCart();
                if ($cantidad > 0) {
                    $cache->setItem($keyCart, $cartModel);
                } else {
                    $cache->removeItem($keyCart);
                    $this->removeCodeCart();
                }
                
                return true;
            }
        } else {
            $cache = $this->getCacheCartService();
            $cache->removeItem($keyCart);
            $this->removeCodeCart();
            return true;
        }
        return false;
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