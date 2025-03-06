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

    public function setPassword()
    {
        return $this->attributes['password'] = password_hash($this->attributes['password'], PASSWORD_DEFAULT);
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

    public function getLastLogin()
    {

        $timestamp = strtotime($this->attributes['last_login']);
        $timeDiff = time() - $timestamp;

        $units = [
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        ];

        if ($this->attributes['last_login'] == null) {
            return 'Never';
        }

        foreach ($units as $seconds => $unit) {
            $interval = floor($timeDiff / $seconds);
            if ($interval >= 1) {
                return $interval . ' ' . $unit . 's ago';
            }
        }

        return 'Just now';

    }

}