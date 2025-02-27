<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $attributes = [
        'id' => null,
        'username' => null,
        'email' => null,
        'password' => null,
        'full_name' => null,
        'role' => null,
        'status' => null,
        'last_login' => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'email' => 'string',
        'password' => 'string',
        'full_name' => 'string',
        'role' => 'string',
        'status' => 'string',
        'last_login' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function setPassword(string $password)
    {
        return $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function isAdmin()
    {
        if ($this->attributes['role'] == "admin" || $this->attributes['role'] == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    public function getFormattedLastLogin()
    {
        return date("Y-m-d H:i:s", strtotime($this->attributes['last_login']));
    }

}