<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Cart\Model\Entity;

class Cart
{
    const CURRENCY_DEFAULT = 'NS';
    const PRODUCTS_NUM_MAX = 5;

    private $currency;
    private $cardId;
    private $products = array();

    public function __construct()
    {
        $this->cardId = 0;
        $this->currency = self::CURRENCY_DEFAULT;
    }

    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    }

    public function getTotalCart()
    {
        $total = 0;
        foreach ($this->products as $products) {
            foreach ($products as $product) {
                $total = $total + $product->getSubTotal();
            }
        }
        return $total;
    }
    
    public function getTotalItem()
    {
        $total = 0;
        if (isset($this->products[$this->cardId])) {
            foreach ($this->products[$this->cardId] as $product) {
                $total = $total + $product->getSubTotal();
            }
        }
        return $total;
    }
    
    public function getQuantityCart()
    {
        $total = 0;
        foreach ($this->products as $products) {
            foreach ($products as $product) {
                $total = $total + $product->getQuantity();
            }
        }
        return $total;
    }
    
    public function getQuantityItem()
    {
        $total = 0;
        if (isset($this->products[$this->cardId])) {
            foreach ($this->products[$this->cardId] as $product) {
                $total = $total + $product->getQuantity();
            }
        }
        return $total;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getAllProducts()
    {
        return $this->products;
    }
    
    public function getProducts()
    {
        if (isset($this->products[$this->cardId])) {
            return $this->products[$this->cardId];
        }
        return array();
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function setProducts(Product $product)
    {
        if ($product->getProductId() != null) {
            if (isset($this->products[$this->cardId][$product->getProductId()])) {
                $oldProduct = $this->products[$this->cardId][$product->getProductId()];
                if (!empty($oldProduct)) {
                    $sumQuantity = $product->getQuantity();
                    if ($oldProduct->getQuantity() < self::PRODUCTS_NUM_MAX) {
                        $sumQuantity = $sumQuantity + $oldProduct->getQuantity();
                        if ($sumQuantity > self::PRODUCTS_NUM_MAX) {
                            $sumQuantity = self::PRODUCTS_NUM_MAX;
                        }
                    } else {
                        $sumQuantity = self::PRODUCTS_NUM_MAX;
                    }
                    $product->setQuantity($sumQuantity);
                    $this->products[$this->cardId][$product->getProductId()] = $product;
                } else {
                    $this->products[$this->cardId][$product->getProductId()] = $product;
                }
            } else {
                $this->products[$this->cardId][$product->getProductId()] = $product;
            }
        }
    }
    
    public function removeProducts($productId = null)
    {
        if (!empty($productId)) {
            if (isset($this->products[$this->cardId][$productId])) {
                unset($this->products[$this->cardId][$productId]);
                return true;
            }
        } else {
            if (isset($this->products[$this->cardId])) {
                unset($this->products[$this->cardId]);
                return true;
            }
        }
        return false;
    }
}