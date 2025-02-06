<?php
namespace App\Models;

use App\Entities\Pesanan;

class M_Pesanan
{
    private $pesanan;
    private $session;


    public function __construct()
    {
        $this->session = session();
        $this->pesanan = $this->session->get('pesanan') ?? [];
    }

    private function saveData()
    {
        $this->session->set('pesanan', $this->pesanan);
    }

    public function getAllPesanan()
    {
        return $this->pesanan;
    }

    public function getPesananById($id)
    {
        foreach ($this->pesanan as $key => $value) {
            if ($value->getId() == $id) {
                return $value;
            }
        }
        return null;
    }

    public function addPesanan(Pesanan $pesanan)
    {
        $this->pesanan[] = $pesanan;
        $this->saveData();
    }

    public function updatePesanan(Pesanan $pesanan)
    {
        foreach ($this->pesanan as $key => $value) {
            if ($value->getId() == $pesanan->getId()) {
                $this->pesanan[$key] = $value;
                $this->saveData();
            }
        }
    }

    public function deletePesanan($id)
    {
        foreach ($this->pesanan as $key => $value) {
            if ($value->getId() == $id) {
                unset($this->pesanan[$key]);
                $this->saveData();
            }
        }
    }

}