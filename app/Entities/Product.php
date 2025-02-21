<?php
namespace App\Entities;

class Product
{
    private $id;
    private $nama;
    private $harga;
    private $stok;
    private $kategori = [];
    private $status;

    public function __construct($id, $nama, $harga, $stok, array $kategori, $status)
    {
        $this->id = $id;
        $this->nama = $nama;
        $this->harga = $harga;
        $this->stok = $stok;
        $this->kategori = $kategori;
        $this->status = $status;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNama()
    {
        return $this->nama;
    }
    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    public function getHarga()
    {
        return $this->harga;
    }
    public function setHarga($harga)
    {
        $this->harga = $harga;
    }

    public function getStok()
    {
        return $this->stok;
    }
    public function setStok($stok)
    {
        $this->stok = $stok;
    }

    public function getKategori()
    {
        // return $this->kategori;
        return is_array($this->kategori) ? $this->kategori : explode(",", $this->kategori);
    }
    public function setKategori($kategori)
    {
        $this->kategori = $kategori;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function kurangiStok($jumlah)
    {
        if ($this->stok > 0) {
            $this->stok -= $jumlah;
        } else {
            $this->stok = 0;
        }
    }

    public function tambahStok($jumlah)
    {
        $this->stok += $jumlah;
    }

}