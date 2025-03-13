<?php

namespace App\Controllers;

use App\Entities\UserEcommerce;
use App\Libraries\DataParams;
use App\Models\M_User;
use App\Models\UserEcommerceModel;
use DateTime;

class UserEcommerceController extends BaseController
{
    private $userModel;
    private $userEntities;
    private $parser;
    public function __construct()
    {
        $this->userModel = new UserEcommerceModel();
        $this->userEntities = new UserEcommerce();
        $this->parser = \Config\Services::parser();
    }

    public function index()
    {
        $params = new DataParams([
            "search" => $this->request->getGet("search"),

            "status" => $this->request->getGet("status"),
            "role" => $this->request->getGet("role"),

            "sort" => $this->request->getGet("sort"),
            "order" => $this->request->getGet("order"),
            "perPage" => $this->request->getGet("perPage"),
            "page" => $this->request->getGet("page_users"),
        ]);

        $result = $this->userModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/user'),
        ];

        return view('user/v_user_list', $data);
    }

    public function detail($id)
    {
        $data['user'] = $this->userModel->getUserById($id);
        return view('user/v_user_detail', $data);
    }
    public function detailParser($id)
    {
        $data = $this->userModel->find($id)->toArray();
        $this->userModel->updateLastLogin($id);

        $data['profile_picture'] = base_url("iconOrang.png");
        $dateTime = (new DateTime())->format("Y-m-d H:i:s");
        $data["activity_history"] = view_cell('ActivityHistoryCell', ['dateTime' => $dateTime]);
        $data["account_status"] = "Active";
        $data["backButton"] = view_cell('BackCell');


        $data['content'] = $this->parser->setData($data)
            ->render(
                "user/v_user_detail_parser",
                // ['cache' => 3600, 'cache_name' => 'user_profile']
            );


        return view("components/v_parser_layout_admin", $data);
    }

    public function role($username)
    {
        $data['user'] = $this->userModel->getUserByUsername($username);
        return view('user/v_user_role', $data);
    }

    public function settings($name)
    {
        $data['user'] = $this->userModel->getUserByName($name);
        return view('user/v_user_settings', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            return view('user/v_user_form');
        }

        if ($type == 'POST') {
            // dd($this->request->getPost());
            $data = [
                'username' => $this->request->getPost("username"),
                'email' => $this->request->getPost("email"),
                'password' => $this->request->getPost("password"),
                'full_name' => $this->request->getPost("full_name"),
                'role' => $this->request->getPost("role"),
                'status' => $this->request->getPost("status"),
                'last_login' => null,
            ];

            if (!$this->userModel->validate($data)) {
                return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
            }

            // $data['password'] = $this->userEntities->setPassword($data['password']);

            $this->userModel->save($data);

            return redirect()->to("admin/user");
        }
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['user'] = $this->userModel->find($id);
            return view('user/v_user_form', $data);
        }

        if ($type == 'PUT') {
            // dd($this->request->getPost());

            $formData = [
                'id' => $id,
                'username' => $this->request->getPost("username"),
                'email' => $this->request->getPost("email"),
                // 'password' => $this->userEntities->setPassword($this->request->getPost("password")),
                'full_name' => $this->request->getPost("full_name"),
                'role' => $this->request->getPost("role"),
                'status' => $this->request->getPost("status"),
            ];

            $this->userModel->setValidationRule("username", "required|is_unique[users.username,id,{$id}]|min_length[3]|max_length[255]");
            $this->userModel->setValidationRule("email", "required|is_unique[users.email,id,{$id}]|valid_email|max_length[255]");

            if (!$this->userModel->validate($formData)) {
                return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
            }

            $this->userModel->save($formData);

            return redirect()->to("/admin/user");
        }
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        return redirect()->to("/admin/user");
    }
}