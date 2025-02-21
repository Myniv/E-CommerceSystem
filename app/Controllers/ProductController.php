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

    public function index()
    {
        $data['products'] = $this->productModel->getAllProduct();
        return view("product/v_product_list", $data);
    }

    public function allProductParser()
    {
        $parser = \Config\Services::parser();

        $products = $this->productModel->getAllProductArray();

        $latestKeys = array_slice(array_keys($products), -3, 3, true);

        foreach ($products as $key => &$product) {
            $product['harga'] = number_format($product['harga'], 0, ',', '.'); // Format: 1000000 -> 1.000.000
            $product['image'] = base_url('search-image.svg');
            
            if ($product['stok'] > 10) {
                $product['stok_message'] = view_cell('ColorTextCell', ['text' => "Available"]);
            } else if ($product["stok"] < 10 && $product["stok"] > 0) {
                $product["stok_message"] = view_cell('ColorTextCell', ['text' => "Limited"]);
            } else if ($product["stok"] == 0) {
                $product["stok_message"] = view_cell('ColorTextCell', ['text' => "SOLD OUT"]);
            }

            if (in_array($key, $latestKeys)) {
                $product['badge_message'] = view_cell('ColorTextCell', ['text' => "NEW"]);
            } else {
                $product['badge_message'] = view_cell('ColorTextCell', ['text' => "SALE"]);
            }
            // $product['status'] = view_cell('ColorTextCell', ['text' => $product['status']]);
        }

        $data = ['products' => $products];
        $data['content'] = $parser->setData($data)
            ->render('product/v_product_catalog_parser', );

        return view("components/v_parser_layout_master", $data);
    }

    public function show($id = null)
    {
        $data['products'] = $this->productModel->getProductById($id);
        return view('/product/v_product_detail', $data);
    }

    public function new()
    {
        return view("/product/v_product_form");
    }

    public function create()
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");
        $status = $this->request->getPost("status");

        $produk = new Product($id, $nama, $harga, $stok, $kategori, $status);

        $this->productModel->addProduct($produk);
        return redirect()->to("admin/product");
    }

    public function edit($id = null)
    {
        $data["products"] = $this->productModel->getProductById($id);
        return view("/product/v_product_form", $data);
    }

    public function update($id = null)
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori");
        $status = $this->request->getPost("status");


        $produk = new Product($id, $nama, $harga, $stok, $kategori, $status);

        $this->productModel->updateProduct($produk);
        return redirect()->to("admin/product");
    }

    public function delete($id = null)
    {
        $this->productModel->deleteProduct($id);
        return redirect()->to("admin/product");
    }
}
