<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\M_Product;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new M_Product();
    }

    // GET /product - Retrieve all products
    public function index()
    {
        $data['products'] = $this->productModel->getAllProduct();
        return view("product/v_product_list", $data);
    }

    // GET /product/{id} - Retrieve a single product
    public function show($id = null)
    {
        $data['products'] = $this->productModel->getProductById($id);
        return view('/product/v_product_detail', $data);
    }
    public function detailProduct   ($id = null)
    {
        $data['products'] = $this->productModel->getProductById($id);
        return view('/product/v_product_detail', $data);
    }

    // GET /product/new - Show form to create a new product
    public function new()
    {
        return view("/product/v_product_form");
    }

    // POST /product - Store a new product
    public function create()
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");

        $produk = new Product($id, $nama, $harga, $stok, $kategori);

        $this->productModel->addProduct($produk);
        return redirect()->to("api/product");
    }

    // GET /product/{id}/edit - Show form to edit a product
    public function edit($id = null)
    {
        $data["products"] = $this->productModel->getProductById($id);
        return view("/product/v_product_form", $data);
    }

    // PUT/PATCH /product/{id} - Update an existing product
    public function update($id = null)
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");

        $produk = new Product($id, $nama, $harga, $stok, $kategori);

        $this->productModel->updateProduct($produk);
        return redirect()->to("api/product");
    }

    // DELETE /product/{id} - Delete a product
    public function delete($id = null)
    {
        $this->productModel->deleteProduct($id);
        return redirect()->to("api/product");
    }
}
