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
                'phone' => $this->request->getPost("phone"),
                'email' => $this->request->getPost("email"),
                'address' => $this->request->getPost("address"),
                'sex' => $this->request->getPost("sex"),
                'role' => $this->request->getPost("role")
            ];
            $rule = [
                'id' => 'required|integer',
                'name' => 'required|max_length[255]',
                'phone' => 'required|max_length[255]|integer',
                'email' => 'required|max_length[255]|valid_email',
                'address' => 'required|max_length[255]',
                'sex' => 'required',
                'role' => 'required'
            ];

            if (!$this->validateData($data, $rule)) {
                return view("user/v_user_form", ['errors' => $this->validator->getErrors()]);
            }

            $user = new User($data['id'], $data['name'], $data['phone'], $data['email'], $data['address'], $data['sex'], $data['role']);

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
                'phone' => $this->request->getPost("phone"),
                'email' => $this->request->getPost("email"),
                'address' => $this->request->getPost("address"),
                'sex' => $this->request->getPost("sex"),
                'role' => $this->request->getPost("role")
            ];
            $rule = [
                'id' => 'required|integer',
                'name' => 'required|max_length[255]',
                'phone' => 'required|max_length[255]|integer',
                'email' => 'required|max_length[255]|valid_email',
                'address' => 'required|max_length[255]',
                'sex' => 'required',
                'role' => 'required'
            ];

            if (!$this->validateData($formData, $rule)) {
                $data['errors'] = $this->validator->getErrors();
                return view("user/v_user_form", $data);
            }

            $user = new User($formData['id'], $formData['name'], $formData['phone'], $formData['email'], $formData['address'], $formData['sex'], $formData['role']);

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