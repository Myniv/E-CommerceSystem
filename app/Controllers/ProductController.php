<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\M_Product;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new M_Product();
    }

    public function allProduct()
    {
        $data['products'] = $this->productModel->getAllProduct();
        return $this->renderView("product/v_product_list", $data);
    }

    public function detailProduct($id)
    {
        $data['products'] = $this->productModel->getProductById($id);
        return view('/product/v_product_detail', $data);
    }

    public function createProduct()
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");

        $produk = new Product($id, $nama, $harga, $stok, $kategori);

        $this->productModel->addProduct($produk);
        return redirect()->to("admin/product");
    }

    public function goCreateProduct()
    {
        return view("/product/v_product_form");
    }

    public function editProduct()
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");

        $produk = new Product($id, $nama, $harga, $stok, $kategori);

        $this->productModel->updateProduct($produk);
        return redirect()->to("admin/product");
    }

    public function goEditProduct($id)
    {
        $data["products"] = $this->productModel->getProductById($id);
        return view("/product/v_product_form", $data);
    }

    public function deleteProduct($id)
    {
        $this->productModel->deleteProduct($id);
        return redirect()->to("admin/product");
    }


}