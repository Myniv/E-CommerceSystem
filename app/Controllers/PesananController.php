<?php

namespace App\Controllers;

use App\Entities\PerProduct;
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
        foreach ($produkIds as $produk) {
            list($produkId, $quantity) = explode(":", $produk); // Extract ID and Quantity

            $product = $this->produkModel->getProductById($produkId);

            if ($product) {
                $perPesanan = new PerProduct(
                    $produkId,
                    $product->getNama(),
                    (int) $quantity,
                    (int) $product->getHarga(),
                    (int) $product->getHarga() * $quantity
                );

                $produkList[] = $perPesanan;
                $product->kurangiStok($quantity);
            }
        }


        $pesanan = new Pesanan($id, $total, $status, $produkList);
        $this->pesananModel->addPesanan($pesanan);

        return redirect()->to("/pesanan");
    }

    public function goCreatePesanan()
    {
        $data["produk"] = $this->produkModel->getAllProduct();
        return $this->renderView("/pesanan/v_pesanan_form_notUsed", $data);
    }

    // public function editPesanan()
    // {
    //     $id = $this->request->getPost("id");
    //     $total = $this->request->getPost("total");
    //     $status = $this->request->getPost("status");
    //     $produkIds = explode(",", $this->request->getPost("produk_ids")); // Convert to array

    //     $produkList = [];
    //     foreach ($produkIds as $produkId) {
    //         $produkList[] = $this->produkModel->getProductById($produkId);
    //     }

    //     $pesanan = new Pesanan($id, $total, $status, $produkList);
    //     $this->pesananModel->updatePesanan($pesanan);

    //     return redirect()->to("/pesanan");
    // }
    public function editPesanan()
    {
        $id = $this->request->getPost("id");
        $total = $this->request->getPost("total");
        $status = $this->request->getPost("status");

        $produkIds = explode(",", $this->request->getPost("produk_ids"));
        $produkList = [];

        foreach ($produkIds as $produkData) {
            list($produkId, $quantity) = explode(":", $produkData);
            $product = $this->produkModel->getProductById($produkId);

            if ($product) {
                $produkList[] = new PerProduct(
                    $product->getId(),
                    $product->getNama(),
                    $quantity,
                    $product->getHarga(),
                    $product->getHarga() * $quantity
                );
            }
        }

        $pesanan = new Pesanan($id, $total, $status, $produkList);

        $this->pesananModel->updatePesanan($pesanan);

        return redirect()->to('/pesanan');
    }


    public function goEditPesanan($id)
    {
        $data["produk"] = $this->produkModel->getAllProduct();
        $data["pesanan"] = $this->pesananModel->getPesananById($id);
        return $this->renderView("/pesanan/v_pesanan_form_notUsed", $data);
    }

    public function deletePesanan($id)
    {
        $this->pesananModel->deletePesanan($id);
        return redirect()->to("/pesanan");
    }

}