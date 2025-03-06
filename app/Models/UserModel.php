<?php

namespace App\Models;

use App\Entities\User;
use App\Libraries\DataParams;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    // protected $returnType = 'array';
    protected $returnType = \App\Entities\User::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        "username",
        'email',
        'password',
        'full_name',
        'role',
        'status',
        'last_login',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|is_unique[users.username,id,{id}]|min_length[3]|max_length[255]',
        'email' => 'required|is_unique[users.email,id,{id}]|valid_email|max_length[255]',
        'password' => 'required|min_length[8]|max_length[255]',
        'full_name' => 'required|min_length[3]|max_length[255]',
        'role' => 'required|in_list[User,Admin]',
        'status' => 'required|in_list[Active,Inactive]',
    ];
    protected $validationMessages = [
        'username' => [
            'required' => 'The username field is required.',
            'is_unique' => 'This username is already taken.',
            'min_length' => 'The username must be at least 3 characters long.',
            'max_length' => 'The username must not exceed 255 characters.'
        ],
        'email' => [
            'required' => 'The email field is required.',
            'is_unique' => 'This email is already registered.',
            'valid_email' => 'Please enter a valid email address.',
            'max_length' => 'The email must not exceed 255 characters.'
        ],
        'password' => [
            'required' => 'The password field is required.',
            'min_length' => 'The password must be at least 8 characters long.',
            'max_length' => 'The password must not exceed 255 characters.'
        ],
        'full_name' => [
            'required' => 'The full name field is required.',
            'min_length' => 'The full name must be at least 3 characters long.',
            'max_length' => 'The full name must not exceed 255 characters.'
        ],
        'role' => [
            'required' => 'The role field is required.',
            'in_list' => 'The role must be either "User" or "Admin".'
        ],
        'status' => [
            'required' => 'The status field is required.',
            'in_list' => 'The status must be either "Active" or "Inactive".'
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


    public function getTotalUsers()
    {
        return $this->countAll();
    }

    public function getActiveUsers()
    {
        return $this->where("status =", "Active")->findAll();
    }

    public function getNewUsersThisMonth()
    {
        $startDate = date('Y-m-01 00:00:00');
        $endDate = date('Y-m-t 23:59:59');
        return $this->where('created_at >=', $startDate)
            ->where('created_at <=', $endDate)
            ->findAll();
    }

    public function updateLastLogin($id)
    {
        return $this->where('id', $id)
            ->set('last_login', date('Y-m-d H:i:s'))
            ->update();
    }

    public function getFilteredUser(DataParams $params)
    {
        if (!empty($params->search)) {
            $this->groupStart()
                ->like('username', $params->search, 'both', null, true)
                ->orLike('email', $params->search, 'both', null, true)
                ->orLike('full_name', $params->search, 'both', null, true)
                ->orLike('role', $params->search, 'both', null, true)
                ->orLike('status', $params->search, 'both', null, true);

            if (is_numeric($params->search)) {
                $this->orWhere('CAST (id AS TEXT) LIKE', "%$params->search%");
            }
            $this->groupEnd();
        }

        if (!empty($params->role)) {
            $this->where('role', $params->role);
        }

        if (!empty($params->status)) {
            $this->where('status', $params->status);
        }

        $allowedSortColumns = ['id', 'username', 'email', 'full_name', 'role', 'status', 'last_login',];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);
        $result = [
            'users' => $this->paginate($params->perPage, 'users', $params->page),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false),
        ];
        return $result;
    }



}
