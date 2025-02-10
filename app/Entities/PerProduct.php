<?php

namespace App\Entities;

class PerProduct
{
    private $id;
    private $productName;
    private $quantity;
    private $price;
    private $totalPrice;

    public function __construct($id, $productName, $quantity, $price, $totalPrice)
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->totalPrice = $totalPrice;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}
