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
    private $price;
    private $quantity;

    private $productId;
    private $productName;
    private $productImage;

    public function __construct()
    {
        $this->price = 0;
        $this->quantity = 0;
        $this->productId = 0;
    }
    
    public function getPrice() {
        return $this->price;
    }

    public function getQuantity() {
        return $this->quantity;
    }

    public function getSubTotal() {
        return $this->quantity * $this->price;
    }
    
    public function getProductId() {
        return $this->productId;
    }

    public function getProductName() {
        return $this->productName;
    }

    public function getProductImage() {
        return $this->productImage;
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

    public function setProductImage($productImage) {
        $this->productImage = $productImage;
    }
}