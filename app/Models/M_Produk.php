<?php
namespace App\Models;

use App\Entities\Produk;

class M_Produk
{
    private $produk;

    private $session;

    private function __construct()
    {
        $this->session = session();
        $this->produk = $this->session->get('produks') ?? [];
    }

    private function saveData()
    {
        $this->session->set('produks', $this->produk);
    }

    public function getAllProduk()
    {
        return $this->produk;
    }

    public function getProdukById($id)
    {
        foreach ($this->produk as $key => $produk) {
            if ($produk->getId() == $id) {
                return $produk;
            }
        }
        return null;
    }

    public function addProduk(Produk $produk)
    {
        $this->produk[] = $produk;
        $this->saveData();
    }

    public function updateProduk(Produk $produk)
    {
        foreach ($this->produk as $key => $value) {
            if ($value->getId() == $produk->getId()) {
                $this->student[$key] = $produk;
                $this->saveData();
            }
        }
    }

    public function removeProduk($id)
    {
        foreach ($this->produk as $key => $value) {
            if ($value->getId() == $id) {
                unset($this->produk[$key]);
                $this->saveData();
            }
        }
    }
}