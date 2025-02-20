<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_Pesanan;
use App\Models\M_Product;
use App\Models\M_User;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    private $userModel;
    private $productModel;
    private $pesananModel;
    public function __construct()
    {
        $this->userModel = new M_User();
        $this->productModel = new M_Product();
        $this->pesananModel = new M_Pesanan();
    }

    public function dashboard()
    {
        $user = count($this->userModel->getUser());
        $product = count($this->productModel->getAllProduct());
        $pesanan = count($this->pesananModel->getAllPesanan());
        $data['product'] = $product;
        $data['user'] = $user;
        $data['pesanan'] = $pesanan;

        return view('v_dashboard', $data);
    }
}
