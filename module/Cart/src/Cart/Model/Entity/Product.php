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
    
    private $price;
    private $quantity;
    private $productId;
    private $productName;
    private $productName2;
    private $productImage;
    private $categoryCode;
    private $categoryName;

    public function __construct($config)
    {
        $this->price = 0;
        $this->quantity = 0;
        $this->productId = 0;

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
    
    public function setPrice($price) {
        $this->price = $price;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
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
    
    public function setCategoryCode($categoryId) {
        $this->categoryCode = $categoryId;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }
}