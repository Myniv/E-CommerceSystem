<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\M_Product;

class ProductController extends BaseController
{
    private $productModel;

    private function __construct()
    {
        $this->productModel = new M_Product();
    }

    public function allProduct()
    {
        $data['products'] = $this->productModel->getAllProduct();
        return view("produk/v_produk_list", $data);
    }

    public function detailProduct($id)
    {
        $data['products'] = $this->productModel->getProductById($id);
        return view('', $data);
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
        return redirect()->to("/product");
    }

    public function goCreateProduct()
    {
        return view("");
    }

    public function editProduct($id)
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");

        $produk = new Product($id, $nama, $harga, $stok, $kategori);

        $this->productModel->updateProduct($produk);
        return redirect()->to("/product");
    }

    public function goEditProduct($id)
    {
        $data["products"] = $this->productModel->getProductById($id);
        return view("", $data);
    }

    public function delete($id)
    {
        $this->productModel->deleteProduct($id);
        return redirect()->to("/product");
    }


}