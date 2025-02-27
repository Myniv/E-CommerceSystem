<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\M_Product;
use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends ResourceController
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
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

        //get filter,search and pagination
        $search = $this->request->getGet("search");
        $categoryFilter = $this->request->getGet("kategori");
        $perPage = 6;
        $currentPage = (int) ($this->request->getGet("page") ?? 1);

        //impelemnt search
        if (!empty($search)) {
            $products = array_filter($products, function ($product) use ($search) {
                return stripos($product['nama'], $search) !== false ||
                    stripos($product['id'], $search) !== false ||
                    stripos($product['harga'], $search) !== false ||
                    stripos($product['stok'], $search) !== false ||
                    stripos(implode(", ", $product['kategori']), $search) !== false ||
                    stripos($product['status'], $search) !== false;
            });
        }

        //impelemnt category filter
        if (!empty($categoryFilter) && $categoryFilter !== 'All') {
            $products = array_filter($products, function ($product) use ($categoryFilter) {
                return in_array($categoryFilter, $product['kategori']);
            });
        }

        //pagination
        $totalProducts = count($products);
        $totalPages = ceil($totalProducts / $perPage);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedProducts = array_slice($products, $offset, $perPage);

        //for get the latest 3 product in array
        $latestKeys = array_slice(array_keys($products), -3, 3, true);

        //implement the data
        foreach ($paginatedProducts as $key => &$product) {
            $product['harga'] = number_format($product['harga'], 0, ',', '.');
            $product['image'] = base_url('search-image.svg');

            $kategoriList = [];
            foreach ($product['kategori'] as $kategori) {
                $kategoriList[] = ['nama_kategori' => $kategori];
            }
            $product['kategori_list'] = $kategoriList;

            if ($product['stok'] > 10) {
                $product['stok_message'] = view_cell('ColorTextCell', ['text' => "Available"]);
            } elseif ($product["stok"] < 10 && $product["stok"] > 0) {
                $product["stok_message"] = view_cell('ColorTextCell', ['text' => "Limited"]);
            } else {
                $product["stok_message"] = view_cell('ColorTextCell', ['text' => "SOLD OUT"]);
            }

            $product['badge_message'] = in_array($key, $latestKeys) ?
                view_cell('ColorTextCell', ['text' => "NEW"]) :
                view_cell('ColorTextCell', ['text' => "SALE"]);
        }

        // make paging
        $pages = [];
        for ($i = 1; $i <= $totalPages; $i++) {
            $pages[] = [
                'page_number' => $i,
                'active' => ($i == $currentPage) ? 'active' : '',
            ];
        }

        $data = [
            'products' => $paginatedProducts,
            'search' => $search,
            'categoryFilter' => $categoryFilter,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
            'prevPage' => ($currentPage > 1) ? $currentPage - 1 : null,
            'nextPage' => ($currentPage < $totalPages) ? $currentPage + 1 : null,
            'pages' => $pages,
            'image' => base_url('search-image.svg'),
        ];

        if (!cache()->get("product-catalog")) {
            cache()->save("product-catalog", $data['products'], 3600);
        } else {
            $this->statistics = cache()->get("product-catalog");
        }

        $data['content'] = $parser->setData($data)->render('product/v_product_catalog_parser');

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
        $kategori = $this->request->getPost('kategori');
        $status = $this->request->getPost("status");

        $kategoriArray = !empty($kategori) ? explode(",", $kategori) : [];

        $produk = new Product($id, $nama, $harga, $stok, $kategoriArray, $status);

        cache()->delete("product-catalog");

        $this->productModel->addProduct($produk);
        return redirect()->to("admin/product");
    }

    public function edit($id = null)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            return redirect()->to("admin/product")->with("error", "Produk tidak ditemukan");
        }

        $data["products"] = $product;
        return view("/product/v_product_form", $data);
    }

    public function update($id = null)
    {
        $id = $this->request->getPost("id");
        $nama = $this->request->getPost("nama");
        $harga = $this->request->getPost("harga");
        $stok = $this->request->getPost("stok");
        $kategori = $this->request->getPost("kategori"); // Expecting an array from form
        $status = $this->request->getPost("status");

        // Convert array to string before saving
        $kategoriArray = !empty($kategori) ? explode(",", $kategori) : [];

        $produk = new Product($id, $nama, $harga, $stok, $kategoriArray, $status);

        cache()->delete("product-catalog");

        $this->productModel->updateProduct($produk);
        return redirect()->to("admin/product")->with("success", "Produk berhasil diperbarui");
    }


    public function delete($id = null)
    {
        $this->productModel->deleteProduct($id);
        cache()->delete("product-catalog");
        return redirect()->to("admin/product");
    }
}
