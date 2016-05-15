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
    private $amountDecimalLength;
    private $amountDecimalSeparator;
    private $amountThousandsSeparator;
    private $quantityMaxByProduct;
    private $currency;
    private $groupProduct;
    private $products = array();

    public function __construct($config)
    {
        $this->groupProduct = 0;
        $defultConfig = array(
            'amount_decimal_length' => 2,
            'amount_decimal_separator' => '.',
            'amount_thousands_separator' => ',',
            'quantity_max_by_product' => 5,
            'currency' => 'NS',
        );
        
        $config = array_merge($config, $defultConfig);
        $this->amountDecimalLength = $config['amount_decimal_length'];
        $this->amountDecimalSeparator = $config['amount_decimal_separator'];
        $this->amountThousandsSeparator = $config['amount_thousands_separator'];
        $this->quantityMaxByProduct = $config['quantity_max_by_product'];
        $this->currency = $config['currency'];
    }

    public function setGroupProduct($cardId)
    {
        $this->groupProduct = $cardId;
    }

    public function getAmountCart($format = false)
    {
        $total = 0;
        foreach ($this->products as $products) {
            foreach ($products as $product) {
                $total = $total + $product->getSubTotal();
            }
        }
        if ($format) {
            $total = number_format($total, $this->amountDecimalLength, 
                    $this->amountDecimalSeparator, $this->amountThousandsSeparator);
        }
        return $total;
    }
    
    public function getAmountGroup($format = false)
    {
        $total = 0;
        if (isset($this->products[$this->groupProduct])) {
            foreach ($this->products[$this->groupProduct] as $product) {
                $total = $total + $product->getSubTotal();
            }
        }
        if ($format) {
            $total = number_format($total, $this->amountDecimalLength, 
                    $this->amountDecimalSeparator, $this->amountThousandsSeparator);
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
    
    public function getQuantityGroup()
    {
        $total = 0;
        if (isset($this->products[$this->groupProduct])) {
            foreach ($this->products[$this->groupProduct] as $product) {
                $total = $total + $product->getQuantity();
            }
        }
        return $total;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getProductsCart()
    {
        return $this->products;
    }
    
    public function getProductsGroup()
    {
        if (isset($this->products[$this->groupProduct])) {
            return $this->products[$this->groupProduct];
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
            $quantity = $product->getQuantity();
            if (isset($this->products[$this->groupProduct][$product->getProductId()])) {
                if ($quantity > $this->quantityMaxByProduct) {
                    $quantity = $this->quantityMaxByProduct;
                }
                if ($quantity < 1) {
                    unset($this->products[$this->groupProduct][$product->getProductId()]);
                } else {
                    $this->products[$this->groupProduct][$product->getProductId()] = $product;
                }
            } else {
                if ($quantity > $this->quantityMaxByProduct) {
                    $quantity = $this->quantityMaxByProduct;
                }
                $this->products[$this->groupProduct][$product->getProductId()] = $product;
            }
        }
    }
    
    public function removeProducts($productId = null)
    {
        if (!empty($productId)) {
            if (isset($this->products[$this->groupProduct][$productId])) {
                unset($this->products[$this->groupProduct][$productId]);
                return true;
            }
        } else {
            if (isset($this->products[$this->groupProduct])) {
                unset($this->products[$this->groupProduct]);
                return true;
            }
        }
        return false;
    }
}