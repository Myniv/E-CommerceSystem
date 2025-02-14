<?php

namespace App\Controllers;

use App\Models\M_Product;
use App\Models\M_User;

class ApiController extends BaseController
{
    private $userModel;
    private $productModel;
    public function __construct()
    {
        $this->userModel = new M_User();
        $this->productModel = new M_Product();
    }

    public function index()
    {
        return view('api/v_json_list');
    }
    public function getAllProductJSON()
    {
        $product = $this->productModel->getAllProduct();
        $data = array_map(function ($product) {
            return [
                "id" => $product->getId(),
                "nama" => $product->getNama(),
                "harga" => $product->getHarga(),
                "stok" => $product->getStok(),
                "kategori" => $product->getKategori(),

            ];
        }, $product);
        return $this->response->setJSON(['status' => 200, 'message' => 'All Product', 'data' => $data]);
    }
    public function getProductJSONById($id)
    {
        $product = $this->productModel->getProductById($id);
        $data =
            [
                "id" => $product->getId(),
                "nama" => $product->getNama(),
                "harga" => $product->getHarga(),
                "stok" => $product->getStok(),
                "kategori" => $product->getKategori(),

            ];
        return $this->response->setJSON(['status' => 200, 'message' => 'Product By Id', 'data' => $data]);
    }

    public function getAllUserJSON()
    {
        $user = $this->userModel->getUser();
        $data = array_map(function ($user) {
            return [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "username" => $user->getUsername(),
                "phone" => $user->getPhone(),
                "email" => $user->getEmail(),
                "address" => $user->getAddress(),
                "sex" => $user->getSex(),
                "role" => $user->getRole(),
            ];
        }, $user);
        return $this->response->setJSON(['status' => 200, 'message' => 'All User', 'data' => $data]);
    }

    public function getUserJSONById($id)
    {
        $user = $this->userModel->getUserById(intval($id));
        $data =
            [
                "id" => $user->getId(),
                "name" => $user->getName(),
                "username" => $user->getUsername(),
                "phone" => $user->getPhone(),
                "email" => $user->getEmail(),
                "address" => $user->getAddress(),
                "sex" => $user->getSex(),
                "role" => $user->getRole(),
            ];
        return $this->response->setJSON(['status' => 200, 'message' => 'User by Id', 'data' => $data]);
    }
}
