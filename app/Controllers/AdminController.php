<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\M_Pesanan;
use App\Models\M_Product;
use App\Models\M_User;
use App\Models\ProductModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    private $userModel;
    private $productModel;
    private $pesananModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
        $this->pesananModel = new M_Pesanan();
    }

    public function dashboard()
    {
        $data['user_total'] = $this->userModel->getTotalUsers();
        $data['user_active'] = $this->userModel->getActiveUsers();
        $data['user_new'] = $this->userModel->getNewUsersThisMonth();
        $data['user_growth'] = "30%";

        $data['product_total'] = $this->productModel->getTotalProducts();
        $data['product_active'] = $this->productModel->getActiveProducts();
        $data['product_outofstock'] = $this->productModel->getLowStockProducts();
        $data['product_onsale'] = $this->productModel->getOnSaleProducts();
        // $product = count($this->productModel->getAllProduct());
        $pesanan = count($this->pesananModel->getAllPesanan());
        $data['product'] = "test";
        $data['pesanan'] = $pesanan;

        return view('admin/v_dashboard', $data);
    }
    public function dashboardParser()
    {
        $parser = \Config\Services::parser();

        $user = $this->userModel->getTotalUsers();
        // $product = count($this->productModel->getAllProduct());
        $pesanan = count($this->pesananModel->getAllPesanan());
        $data = [
            // 'product' => $product,
            'user' => $user,
            'pesanan' => $pesanan,
            'statistics' => view_cell('ProductStatisticsCell', ['productStock' => 60, 'productPrice' => 35000]),
        ];

        $data['title'] = "Dashboard";

        $data['content'] = $parser->setData($data)
            ->render(
                "admin/v_dashboard_parser",
                // ['cache' => 3600, 'cache_name' => 'student_profile']
            );


        return view("components/v_parser_layout_admin", $data);
    }
}
