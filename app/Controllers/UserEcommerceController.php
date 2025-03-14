<?php

namespace App\Controllers;

use App\Entities\UserEcommerce;
use App\Libraries\DataParams;
use App\Models\M_User;
use App\Models\UserEcommerceModel;
use DateTime;

class UserEcommerceController extends BaseController
{
    private $userEcommerceModel;
    private $userEcommerceEntities;
    private $parser;
    public function __construct()
    {
        $this->userEcommerceModel = new UserEcommerceModel();
        $this->userEcommerceEntities = new UserEcommerce();
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

        $result = $this->userEcommerceModel->getFilteredUser($params);

        $data = [
            'users' => $result['users'],
            'pager' => $result['pager'],
            'total' => $result['total'],
            'params' => $params,
            'baseUrl' => base_url('admin/customer'),
        ];

        return view('user/v_user_list', $data);
    }

    public function detail($id)
    {
        $data['user'] = $this->userEcommerceModel->getUserById($id);
        return view('user/v_user_detail', $data);
    }
    public function detailParser($id)
    {
        $data = $this->userEcommerceModel->find($id)->toArray();
        $this->userEcommerceModel->updateLastLogin($id);

        $data['profile_picture'] = base_url("iconOrang.png");
        $dateTime = (new DateTime())->format("Y-m-d H:i:s");
        $data["activity_history"] = view_cell('ActivityHistoryCell', ['dateTime' => $dateTime]);
        $data["account_status"] = "Active";
        $data["backButton"] = view_cell('BackCell');
        $data['editButton'] = "";

        $data['content'] = $this->parser->setData($data)
            ->render(
                "user/v_user_detail_parser",
                // ['cache' => 3600, 'cache_name' => 'user_profile']
            );

        return view("components/v_parser_layout_admin", $data);
    }
    public function profile()
    {
        $user = user()->username;
        $data = $this->userEcommerceModel->getUserByUsername($user)->toArray();

        $data['profile_picture'] = base_url("iconOrang.png");
        $dateTime = (new DateTime())->format("Y-m-d H:i:s");
        $data["activity_history"] = view_cell('ActivityHistoryCell', ['dateTime' => $dateTime]);
        $data["account_status"] = "Active";
        $data["backButton"] = view_cell('BackCell');
        $data['editButton'] = "<a class='btn btn-primary mb-3' href='/profile/edit'>Edit</a>";

        $data['content'] = $this->parser->setData($data)
            ->render(
                "user/v_user_detail_parser",
                // ['cache' => 3600, 'cache_name' => 'user_profile']
            );

        return view("components/v_parser_layout_admin", $data);
    }

    public function editProfile()
    {
        $user = user()->username;
        $getUser = $this->userEcommerceModel->getUserByUsername($user);

        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['user'] = $getUser;
            return view('user/v_user_form', $data);
        }

        $formData = [
            'id' => $getUser->id,
            'full_name' => $this->request->getPost("full_name"),
            'status' => $this->request->getPost("status"),
        ];

        if (!$this->userEcommerceModel->validate($formData)) {
            return redirect()->back()->withInput()->with('errors', $this->userEcommerceModel->errors());
        }

        $this->userEcommerceModel->save($formData);

        return redirect()->to("/profile");
    }

    public function role($username)
    {
        $data['user'] = $this->userEcommerceModel->getUserByUsername($username);
        return view('user/v_user_role', $data);
    }

    public function settings($name)
    {
        $data['user'] = $this->userEcommerceModel->getUserByName($name);
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

            if (!$this->userEcommerceModel->validate($data)) {
                return redirect()->back()->withInput()->with('errors', $this->userEcommerceModel->errors());
            }

            // $data['password'] = $this->userEntities->setPassword($data['password']);

            $this->userEcommerceModel->save($data);

            return redirect()->to("admin/customer");
        }
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == "GET") {
            $data['user'] = $this->userEcommerceModel->find($id);
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

            $this->userEcommerceModel->setValidationRule("username", "required|is_unique[users.username,id,{$id}]|min_length[3]|max_length[255]");
            $this->userEcommerceModel->setValidationRule("email", "required|is_unique[users.email,id,{$id}]|valid_email|max_length[255]");

            if (!$this->userEcommerceModel->validate($formData)) {
                return redirect()->back()->withInput()->with('errors', $this->userEcommerceModel->errors());
            }

            $this->userEcommerceModel->save($formData);

            return redirect()->to("/admin/customer");
        }
    }

    public function delete($id)
    {
        $this->userEcommerceModel->delete($id);
        return redirect()->to("/admin/customer");
    }
}