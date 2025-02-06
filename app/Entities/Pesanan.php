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
        $productCounts = [];

        foreach ($this->produk as $product) {
            $productName = $product->getNama();
            $quantity = 1;
            $harga = $product->getHarga();

            if (isset($productCounts[$productName])) {
                $productCounts[$productName]['quantity'] += $quantity;
                $productCounts[$productName]['harga'] += $harga;
            } else {
                $productCounts[$productName] = [
                    'quantity' => $quantity,
                    'harga' => $harga
                ];
            }
        }

        $productList = [];
        foreach ($productCounts as $name => $data) {
            $productList[] = "({$name} {$data['quantity']}x - Rp {$data['harga']})";
        }

        return implode(", ", $productList);
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