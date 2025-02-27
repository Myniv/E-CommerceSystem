<?php

namespace App\Controllers;

use App\Models\M_Product;
use App\Models\M_User;
use App\Models\ProductModel;
use App\Models\UserModel;

class ApiController extends BaseController
{
    private $userModel;
    private $productModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        return view('api/v_json_list');
    }
    public function getAllProductJSON()
    {
        $products = $this->productModel->findAll();
        $data = [];
        foreach ($products as $product) {
            $data[] = $product->toArray();
        }
        return $this->response->setJSON(['status' => 200, 'message' => 'All Product', 'data' => $data]);
    }
    public function getProductJSONById($id)
    {
        $data = $this->productModel->find($id)->toArray();
        return $this->response->setJSON(['status' => 200, 'message' => 'Product By Id', 'data' => $data]);
    }

    public function getAllUserJSON()
    {
        $users = $this->userModel->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = $user->toArray();
        }
        return $this->response->setJSON(['status' => 200, 'message' => 'All User', 'data' => $data]);
    }

    public function getUserJSONById($id)
    {
        $data = $this->userModel->find($id)->toArray();
        return $this->response->setJSON(['status' => 200, 'message' => 'User by Id', 'data' => $data]);
    }
}
