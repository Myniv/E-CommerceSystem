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
        $session = session();
        $role = $session->get("login");
        $data["role"] = $role;
        return view('welcome_message', $data);
    }
    public function production(): string
    {
        $session = session();
        $role = $session->get("login");
        $data["role"] = $role;
        return view('production_page', $data);
    }
    public function aboutUs(): string
    {
        return view('about_us');
    }
    
    public function show()
    {
        echo "Show Option Route";
    }

    public function login()
    {
        $session = session();
        $role = $this->request->getPost("role");

        if ($role == "admin" || $role == "user") {
            $session->set("login", $role);
            $data["role"] = $role;
            return view("welcome_message", $data);
        }
    }
    public function unauthorized()
    {
        return view("unauthorized_page");
    }
}
