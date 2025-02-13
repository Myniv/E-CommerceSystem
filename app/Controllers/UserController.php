<?php

namespace App\Controllers;

use App\Entities\User;
use App\Models\M_User;

class UserController extends BaseController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new M_User();
    }

    public function index()
    {
        $data['users'] = $this->userModel->getUser();
        return view('user/v_user_list', $data);
    }

    public function detail($id)
    {
        $data['user'] = $this->userModel->getUserById($id);
        return view('user/v_user_detail', $data);
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
                'id' => $this->request->getPost("id"),
                'name' => $this->request->getPost("name"),
                'username' => $this->request->getPost("username"),
                'phone' => $this->request->getPost("phone"),
                'email' => $this->request->getPost("email"),
                'address' => $this->request->getPost("address"),
                'sex' => $this->request->getPost("sex"),
                'role' => $this->request->getPost("role")
            ];
            $rule = [
                'id' => 'required|integer',
                'name' => 'required|max_length[255]',
                'username' => 'required|max_length[255]',
                'phone' => 'required|max_length[255]|integer',
                'email' => 'required|max_length[255]|valid_email',
                'address' => 'required|max_length[255]',
                'sex' => 'required',
                'role' => 'required'
            ];

            if (!$this->validateData($data, $rule)) {
                return view("user/v_user_form", ['errors' => $this->validator->getErrors()]);
            }

            $user = new User($data['id'], $data['name'], $data['username'], $data['phone'], $data['email'], $data['address'], $data['sex'], $data['role']);

            $this->userModel->addUser($user);
            return redirect()->to("admin/user");
        }
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        $data['user'] = $this->userModel->getUserById($id);
        if ($type == "GET") {
            return view('user/v_user_form', $data);
        }

        if ($type == 'PUT') {
            // dd($this->request->getPost());

            $formData = [
                'id' => $this->request->getPost("id"),
                'name' => $this->request->getPost("name"),
                'username' => $this->request->getPost("username"),
                'phone' => $this->request->getPost("phone"),
                'email' => $this->request->getPost("email"),
                'address' => $this->request->getPost("address"),
                'sex' => $this->request->getPost("sex"),
                'role' => $this->request->getPost("role")
            ];
            $rule = [
                'id' => 'integer',
                'name' => 'max_length[255]',
                'username' => 'max_length[255]',
                'phone' => 'max_length[255]',
                'email' => 'max_length[255]',
                'address' => 'max_length[255]',
                'sex' => 'max_length[255]',
                'role' => 'max_length[255]'
            ];

            // if (!$this->validateData($data, $rule)) {
            //     $data['errors'] = $this->validator->getErrors();
            //     return view("user/v_user_form", $data);
            // }

            $user = new User($formData['id'], $formData['name'], $formData['username'], $formData['phone'], $formData['email'], $formData['address'], $formData['sex'], $formData['role']);

            $this->userModel->updateUser($user);
            return redirect()->to("/admin/user");
        }
    }

    public function delete($id)
    {
        $this->userModel->deleteUser($id);
        return redirect()->to("/admin/user");
    }
}