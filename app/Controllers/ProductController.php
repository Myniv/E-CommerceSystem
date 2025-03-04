<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Models\CategoryModel;
use App\Models\M_Product;
use App\Models\ProductImageModel;
use App\Models\ProductModel;
use CodeIgniter\RESTful\ResourceController;

class ProductController extends BaseController
{
    private $productModel;
    private $categoryModel;

    private $productImageModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productImageModel = new ProductImageModel();
    }

    public function index()
    {
        // $data['products'] = $this->productModel->getProductWithCategories()->findAll();
        $data['products'] = $this->productModel->getProductWithCategories()->paginate(1, 'products');
        $data['pager'] = $this->productModel->pager;
        return view("product/v_product_list", $data);
    }

    public function allProductParser()
    {
        $parser = \Config\Services::parser();
        $products = $this->productModel->getProductWithCategoriesAndImagePrimary()->findAll();
        // print_r($products);
        $categoris = $this->categoryModel->select("id, name")->findAll();
        $categoryArray = [];
        foreach ($categoris as $category) {
            $categoryArray[] = $category->toArray();
        }

        $search = $this->request->getGet("search");
        $categoryFilter = $this->request->getGet("category");

        // Implement search
        if (!empty($search)) {
            $products = array_filter($products, function ($product) use ($search) {
                return stripos($product->name, $search) !== false ||
                    stripos($product->id, $search) !== false ||
                    stripos($product->description, $search) !== false ||
                    stripos($product->price, $search) !== false ||
                    stripos($product->stock, $search) !== false ||
                    stripos($product->status, $search) !== false ||
                    stripos($product->category_name, $search) !== false;
            });
        }

        if (!empty($categoryFilter) && $categoryFilter !== 'All') {
            $products = array_filter($products, function ($product) use ($categoryFilter) {
                return $product->category_id == $categoryFilter;
            });
        }

        $productsArray = [];
        foreach ($products as $product) {
            $productArray = $product->toArray();

            $productArray['price'] = $product->getFormattedPrice();
            $productArray['image_path'] = base_url($product->image_path ? $product->image_path : 'search-image.svg');

            if ($product->stock > 10) {
                $productArray['stok_message'] = view_cell('ColorTextCell', ['text' => "Available"]);
            } elseif ($product->stock < 10 && $product->stock > 0) {
                $productArray["stok_message"] = view_cell('ColorTextCell', ['text' => "Limited"]);
            } else {
                $productArray["stok_message"] = view_cell('ColorTextCell', ['text' => "SOLD OUT"]);
            }

            $productsArray[] = $productArray;
        }

        $data = [
            'products' => $productsArray,
            'search' => $search,
            'categoryFilter' => $categoryFilter,
            'categories' => $categoryArray,
        ];

        if (!cache()->get("product-catalog")) {
            cache()->save("product-catalog", $data['products'], 3600);
        }

        $data['content'] = $parser->setData($data)->render('product/v_product_catalog_parser');

        return view("components/v_parser_layout_master", $data);
    }



    public function show($id = null)
    {
        $data['products'] = $this->productModel->getProductWithCategoriesAndImagePrimary()
            ->find($id);
        // $data['image_path'] = $this->productImageModel->select('image_path')->where('product_id =', $id)->find($id);

        // print_r($data['products']);
        return view('/product/v_product_detail', $data);
    }

    public function new()
    {
        $data['activeornot'] = ['Active', 'Inactive'];
        $data['trueorfalse'] = ['True', 'False'];
        $data['categories'] = $this->categoryModel->select('id, name')->findAll();
        return view("/product/v_product_form", $data);
    }

    public function create()
    {
        $formData = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            // 'category_id' => explode(",", $this->request->getPost('category_id')),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'is_new' => $this->request->getPost('is_new'),
            'is_sale' => $this->request->getPost('is_sale'),
        ];

        if (!$this->productModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        cache()->delete("product-catalog");

        $this->productModel->save($formData);
        return redirect()->to("admin/product");
    }

    public function edit($id = null)
    {
        $product = $this->productModel->find($id);

        $data['activeornot'] = ['Active', 'Inactive'];
        $data['trueorfalse'] = ['True', 'False'];
        $data['categories'] = $this->categoryModel->select('id, name')->findAll();
        $data["products"] = $product;
        return view("/product/v_product_form", $data);
    }

    public function update($id = null)
    {
        $formData = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            // 'category_id' => explode(",", $this->request->getPost('category_id')),
            'category_id' => $this->request->getPost('category_id'),
            'status' => $this->request->getPost('status'),
            'is_new' => $this->request->getPost('is_new'),
            'is_sale' => $this->request->getPost('is_sale'),
        ];


        if (!$this->productModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->productModel->errors());
        }

        cache()->delete("product-catalog");

        $this->productModel->save($formData);
        return redirect()->to("admin/product");
    }


    public function delete($id = null)
    {
        $this->productModel->delete($id);
        cache()->delete("product-catalog");
        return redirect()->to("admin/product");
    }


}
