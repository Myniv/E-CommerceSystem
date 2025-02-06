<?php
namespace App\Entities;

class Pesanan
{
    private $id;
    private $produk = [];
    private $total;
    private $status;

    public function __construct($id, $total, $status, array $products)
    {
        $this->id = $id;
        $this->produk = $products;
        $this->total = $total;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getProduct()
    {
        $productList = [];
        foreach ($this->produk as $product) {
            $productList[] = "{$product->getNama()}";
        }
        return implode(", ", $productList); // Join products with commas
    }


    public function getTotal()
    {
        return $this->total;
    }

    public function getStatus()
    {
        return $this->status;
    }
}