<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Myth\Auth\Models\GroupModel;

class RoleController extends BaseController
{
    protected $roleModel;
    public function __construct()
    {
        $this->roleModel = new GroupModel();
    }

    public function index()
    {
        $data['roles'] = $this->roleModel->findAll();
        return view('role/v_role_list', $data);
    }

    public function create()
    {
        $type = $this->request->getMethod();
        if ($type == 'GET') {
            return view('/role/v_role_form');
        }

        if ($type == 'POST') {
            $data = [
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            // $this->roleModel->setValidationRule("name", "required|max_length[255]|is_unique[auth_groups.name,name,{$data['name']}]");
            if (!$this->roleModel->validate($data)) {
                return redirect()->back()->withInput()->with('errors', $this->roleModel->errors());
            }
            $this->roleModel->save($data);

            return redirect()->to('admin/role');
        }
    }

    public function update($id)
    {
        $type = $this->request->getMethod();
        if ($type == 'GET') {
            $data['role'] = $this->roleModel->find($id);
            return view('/role/v_role_form', $data);
        }

        if ($type == 'PUT' || $type == 'POST') {
            $data = [
                'id' => $id,
                'name' => $this->request->getPost('name'),
                'description' => $this->request->getPost('description'),
            ];

            $this->roleModel->save($data);

            return redirect()->to('admin/roles');
        }
    }

    public function delete($id)
    {
        $this->roleModel->delete($id);
        return redirect()->to('admin/roles');
    }
}
