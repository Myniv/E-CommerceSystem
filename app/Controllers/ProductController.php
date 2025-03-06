<?php

namespace App\Controllers;

use App\Entities\Product;
use App\Libraries\DataParams;
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
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "category_id" => $this->request->getGet("category_id"),
            "price_range" => $this->request->getGet("price_range"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
        ]);

        $result = $this->productModel->getFilteredProducts($params);

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'categories' => $this->categoryModel->findAll(),
            'statuss' => $this->productModel->getAllStatus(),
            'baseUrl' => base_url('admin/product'),
        ];
        return view("product/v_product_list", $data);
    }

    public function allProductParser()
    {
        $parser = \Config\Services::parser();

        $categoryId = $this->request->getGet("category_id");
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "category_id" => $categoryId,
            "price_range" => $this->request->getGet("price_range"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_products"),
        ]);

        $result = $this->productModel->getFilteredProducts($params);

        // print_r($result['products']);
        foreach ($result['products'] as &$product) {
            if ($product->image_path != null) {
                $product->image_path = base_url($product->image_path);
            } else {
                $product->image_path = base_url('products/search-image.svg');
            }

            if ($product->stock > 10) {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "Available"]);
            } elseif ($product->stock < 10 && $product->stock > 0) {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "Limited"]);
            } else {
                $product->stok_message = view_cell('ColorTextCell', ['text' => "SOLD OUT"]);
            }

            if (strtolower($product->is_new) == 'true') {
                $product->is_new_message = view_cell('ColorTextCell', ['text' => "NEW", 'item' => 'is_new']);
            } else {
                $product->is_new_message = "";
            }

            if (strtolower($product->is_sale) == 'true') {
                $product->is_sale_message = view_cell('ColorTextCell', ['text' => "SALE", 'item' => 'is_sale']);
            } else {
                $product->is_sale_message = "";
            }
        }
        unset($product);

        $categories = $this->categoryModel->findAll();
        foreach ($categories as &$category) {
            $category->selected = ($category->id == $categoryId) ? 'selected' : '';
        }

        $data = [
            'products' => $result['products'],
            'pager' => $result['pager']->links('products', 'custom_pager'),
            'total' => $result['total'],
            'search' => $params->search,
            'reset' => $params->getResetUrl(base_url('product/catalog')),
            'order' => $params->order,
            'sort' => $params->sort,
            'page' => $params->page,
            'categories' => $categories,
            'statuss' => $this->productModel->getAllStatus(),
            'baseUrl' => base_url('product/catalog'),
            'perPageOptions' => [
                ['value' => 5, 'selected' => ($params->perPage == 5) ? 'selected' : ''],
                ['value' => 10, 'selected' => ($params->perPage == 10) ? 'selected' : ''],
                ['value' => 25, 'selected' => ($params->perPage == 25) ? 'selected' : ''],
            ],
            'sorting' => [
                [
                    'name' => 'Price',
                    'href' => $params->getSortUrl('price', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('price') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : ''
                ],
                [
                    'name' => 'Name',
                    'href' => $params->getSortUrl('name', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('name') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : ''
                ],
                [
                    'name' => 'Date',
                    'href' => $params->getSortUrl('created_at', base_url('product/catalog')),
                    'is_sorted' => $params->isSortedBy('created_at') ? ($params->getSortDirection() == 'asc' ?
                        '↑' : '↓') : ''
                ],
            ]
        ];

        if (!cache()->get("product-catalog")) {
            // cache()->save("product-catalog", $data['products'], 3600);
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
