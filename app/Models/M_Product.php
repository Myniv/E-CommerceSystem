<?php
namespace App\Models;

use App\Entities\Product;

class M_Product
{
    private $product;

    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->product = $this->session->get('products') ?? [];
    }

    private function saveData()
    {
        $this->session->set('products', $this->product);
    }

    public function getAllProduct()
    {
        return $this->product;
    }

    public function getProductById($id)
    {
        foreach ($this->product as $key => $value) {
            if ($value->getId() == $id) {
                return $value;
            }
        }
        return null;
    }

    public function addProduct(Product $product)
    {
        $this->product[] = $product;
        $this->saveData();
    }

    public function updateProduct(Product $product)
    {
        foreach ($this->product as $key => $value) {
            if ($value->getId() == $product->getId()) {
                $this->product[$key] = $product;
                $this->saveData();
            }
        }
    }

    public function deleteProduct($id)
    {
        foreach ($this->product as $key => $value) {
            if ($value->getId() == $id) {
                unset($this->product[$key]);
                $this->saveData();
            }
        }
    }

    public function kurangiStok($jumlah)
    {
        $this->product->kurangiStok($jumlah);
    }

    public function tambahStok($jumlah)
    {
        $this->product->tambahStok($jumlah);
    }
}