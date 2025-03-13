<?php

namespace App\Controllers;

use App\Models\UserEcommerceModel;
use Myth\Auth\Controllers\AuthController as MythController;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Models\GroupModel;

class AuthController extends MythController
{
    protected $auth;
    protected $config;
    protected $userModel;
    protected $userEcommerceModel;
    protected $groupModel;

    public function __construct()
    {
        parent::__construct();

        $this->userModel = new UserModel();
        $this->groupModel = new GroupModel();
        $this->userEcommerceModel = new UserEcommerceModel();

        $this->auth = service('authentication');
    }

    public function login()
    {
        return parent::login();
    }

    public function attemptLogin()
    {
        $result = parent::attemptLogin();
        $this->updateUserEcommerceStatusLastLogin();
        return $this->redirectBasedOnRole();
    }

    public function attemptRegister()
    {
        $result = parent::attemptRegister();

        $email = $this->request->getPost('email');
        $user = $this->userModel->where('email', $email)->first();
        $userArray = $this->userModel->asArray()->where('email', $email)->first();


        if ($user) {
            // $studentGroup = $this->groupModel->where('name', 'admin')->first();
            // $studentGroup = $this->groupModel->where('name', 'lecturer')->first();
            $studentGroup = $this->groupModel->where('name', 'Customer')->first();
            if ($studentGroup) {
                $this->groupModel->addUserToGroup($user->id, $studentGroup->id);
            }

            $registUserEcommerce = [
                'username' => $user->username,
                'email' => $email,
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'full_name' => $this->request->getPost('full_name'),
                'role' => 'Customer',
                // 'status' => $user->active,
                'last_login' => null,
            ];

            if ($user->active == 1 || $user->active == true) {
                $registUserEcommerce['status'] = "Active";
            } else {
                $registUserEcommerce['status'] = "Inactive";
            }

            if (!$this->userEcommerceModel->save($registUserEcommerce)) {
                dd($this->userEcommerceModel->errors());
            }
        }

        return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
    }

    private function redirectBasedOnRole()
    {
        $userId = user_id();
        if (!$userId) {
            return redirect()->to('/login');
        }

        $userGroups = $this->groupModel->getGroupsForUser($userId);
        foreach ($userGroups as $group) {
            if ($group['name'] === 'Administrator') {
                return redirect()->to('/admin/dashboard');
            } else if ($group['name'] === 'Product Manager') {
                return redirect()->to('/product-manager/dashboard');
            } else if ($group['name'] === 'Customer') {
                return redirect()->to('/customer/dashboard');
            }
        }

        return redirect()->to('/');
    }

    public function unauthorized()
    {
        return view("auth/unauthorized_page");
    }

    public function updateUserEcommerceStatusLastLogin()
    {
        $userId = user_id();
        if (!$userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);
        $userEcommerce = $this->userEcommerceModel->getUserLogin($user->username);
        $data['id'] = $userEcommerce->id;
        if ($user->active == 1 || $user->active == true) {
            $data['status'] = "Active";
        } else {
            $data['status'] = "Inactive";
        }
        $data['last_login'] = date('Y-m-d H:i:s');
        if (!$this->userEcommerceModel->save($data)) {
            dd($this->userEcommerceModel->errors());
        }
    }
}