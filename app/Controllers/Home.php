<?php

namespace App\Controllers;

use App\Models\M_Product;
use App\Models\M_User;

class Home extends BaseController
{
    private $userModel;
    private $productModel;
    public function __construct()
    {
        $this->userModel = new M_User();
        $this->productModel = new M_Product();
    }
    public function development(): string
    {
        return view('welcome_message');
    }
    public function production(): string
    {
        return view('production_page');
    }
    public function aboutUs(): string
    {
        return view('about_us');
    }
    public function dashboard()
    {
        $user = count($this->userModel->getUser());
        $product = count($this->productModel->getAllProduct());
        $data['product'] = $product;
        $data['user'] = $user;

        return view('v_dashboard', $data);
    }
    public function show()
    {
        echo "Show Option Route";
    }
}
