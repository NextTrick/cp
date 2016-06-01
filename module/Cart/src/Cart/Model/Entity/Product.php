<?php
/*
 * Autor       : Juan Carlos Ludeña Montesinos
 * Año         : Mayo 2016
 * Descripción :
 *
 */

namespace Cart\Model\Entity;


class Product
{
    private $amountDecimalLength;
    private $amountDecimalSeparator;
    private $amountThousandsSeparator;
    
    private $price = 0;
    private $quantity = 0;
    private $productId = 0;
    private $productName = null;
    private $productName2 = null;
    private $productImage = null;
    private $categoryCode = null;
    private $categoryName = null;
    private $timestamp = null;
    private $options = array();

    public function __construct($config)
    {
        $this->amountDecimalLength = $config['amount_decimal_length'];
        $this->amountDecimalSeparator = $config['amount_decimal_separator'];
        $this->amountThousandsSeparator = $config['amount_thousands_separator'];
    }
    
    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getAmount($format = false) {
        $amount = $this->quantity * $this->price;
        if ($format) {
            $amount = number_format($amount, $this->amountDecimalLength, 
                $this->amountDecimalSeparator, $this->amountThousandsSeparator);
        }
        return $amount;
    }
    
    public function getProductId() {
        return $this->productId;
    }

    public function getProductName() {
        return $this->productName;
    }
    
    public function getProductName2() {
        return $this->productName2;
    }

    public function getProductImage() {
        return $this->productImage;
    }

    public function getCategoryCode() {
        return $this->categoryCode;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function getOptions() {
        return $this->options;
    }
    
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    public function getOption($key, $format = false) {
        if (isset($this->options[$key])) {
            $value = $this->options[$key];
            if ($format) {
                $value = number_format($value, $this->amountDecimalLength, 
                    $this->amountDecimalSeparator, $this->amountThousandsSeparator);
            }
            return $value;
        }

        return null;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = (int)$quantity;
    }

    public function setProductId($productId) {
        $this->productId = $productId;
    }

    public function setProductName($productName) {
        $this->productName = $productName;
    }
    
    public function setProductName2($productName2) {
        $this->productName2 = $productName2;
    }

    public function setProductImage($productImage) {
        $this->productImage = $productImage;
    }
    
    public function setCategoryCode($categoryCode) {
        $this->categoryCode = $categoryCode;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }
    
    public function setOptions($options) {
        $this->options = $options;
    }
    
    public function setOption($key, $value) {
        $this->options[$key] = $value;
    }
    
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
        
    public function toArray()
    {
        return get_object_vars($this);
    }
    
    public function populate($data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (is_callable($method)) {
                $this->$method($value);
            }
        }
    }
}