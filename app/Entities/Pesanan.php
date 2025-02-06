<?php
namespace App\Entities;

class Pesanan
{
    private $id;
    private $produk;
    private $total;
    private $status;

    public function __construct($id, $total, $status)
    {
        $this->id = $id;
        $this->produk = new Product();
        $this->total = $total;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTotal()
    {
        return $this->total;
    }
}