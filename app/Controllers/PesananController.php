<?php

namespace App\Controllers;

use App\Entities\Pesanan;
use App\Models\M_Pesanan;
use App\Models\M_Product;

class PesananController extends BaseController
{
    private $pesananModel;
    private $produkModel;
    public function __construct()
    {
        $this->pesananModel = new M_Pesanan();
        $this->produkModel = new M_Product();
    }

    public function allPesanan()
    {
        $data["pesanan"] = $this->pesananModel->getAllPesanan();
        return $this->renderView("pesanan/v_pesanan_list", $data);
    }

    public function detailPesanan($id)
    {
        $data["pesanan"] = $this->pesananModel->getPesananById($id);
        return $this->renderView("pesanan/v_pesanan_detail", $data);
    }

    public function createPesanan()
    {
        $id = $this->request->getPost("id");
        $total = $this->request->getPost("total");
        $status = $this->request->getPost("status");
        $produkIds = explode(",", $this->request->getPost("produk_ids")); // Convert to array

        $produkList = [];
        foreach ($produkIds as $produkId) {
            $product = $this->produkModel->getProductById($produkId);

            $produkList[] = $product;
            $quantity = 1;
            $product->kurangiStok($quantity);
        }


        $pesanan = new Pesanan($id, $total, $status, $produkList);
        $this->pesananModel->addPesanan($pesanan);

        return redirect()->to("/pesanan");
    }

    public function goCreatePesanan()
    {
        $data["produk"] = $this->produkModel->getAllProduct();
        return $this->renderView("/pesanan/v_pesanan_form", $data);
    }

    public function editPesanan()
    {
        $id = $this->request->getPost("id");
        $total = $this->request->getPost("total");
        $status = $this->request->getPost("status");
        $produkIds = explode(",", $this->request->getPost("produk_ids")); // Convert to array

        $produkList = [];
        foreach ($produkIds as $produkId) {
            $produkList[] = $this->produkModel->getProductById($produkId);
        }

        $pesanan = new Pesanan($id, $total, $status, $produkList);
        $this->pesananModel->updatePesanan($pesanan);

        return redirect()->to("/pesanan");
    }

    public function goEditPesanan($id)
    {
        $data["produk"] = $this->produkModel->getAllProduct();
        $data["pesanan"] = $this->pesananModel->getPesananById($id);
        return $this->renderView("/pesanan/v_pesanan_form", $data);
    }

    public function deletePesanan($id)
    {
        $this->pesananModel->deletePesanan($id);
        return redirect()->to("/pesanan");
    }

}