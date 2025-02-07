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
            $productName = $product->getNama();
            $quantity = 1;
            $harga = $product->getHarga();

            if (isset($productList[$productName])) {
                $productList[$productName]['quantity'] += $quantity;
                $productList[$productName]['harga'] += $harga;
            } else {
                $productList[$productName] = [
                    'nama' => $productName,
                    'quantity' => $quantity,
                    'harga' => $harga
                ];
            }
        }

        return array_values($productList); // Return as an indexed array
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