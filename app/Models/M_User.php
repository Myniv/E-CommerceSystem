<?php
namespace App\Models;

use App\Entities\UserEcommerce;

class M_User
{
    private $user;
    private $session;

    public function __construct()
    {
        $this->session = session();
        $this->user = $this->session->get('users') ?? [];
    }

    private function saveData()
    {
        $this->session->set('users', $this->user);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserById($id)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getId() == $id) {
                return $value;
            }
        }
        return null;
    }
    public function getUserByIdArray($id)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getId() == $id) {
                return [
                    'id' => $value->getId(),
                    'name' => $value->getName(),
                    'username' => $value->getUsername(),
                    'phone' => $value->getPhone(),
                    'email' => $value->getEmail(),
                    'address' => $value->getAddress(),
                    'sex' => $value->getSex(),
                    'role' => $value->getRole()
                ];
            }
        }
        return null;
    }

    public function getUserByUsername($username)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getUsername() == $username) {
                return $value;
            }
        }
        return null;
    }
    public function getUserByUsernameandID($username, $id)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getUsername() == $username && $value->getId() == $id) {
                return $value;
            }
        }
        return null;
    }

    public function getUserByName($name)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getName() == $name) {
                return $value;
            }
        }
        return null;
    }

    public function addUser(UserEcommerce $user)
    {
        $this->user[] = $user;
        $this->saveData();
    }

    public function updateUser(UserEcommerce $user)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getId() == $user->getId()) {
                $this->user[$key] = $user;
                $this->saveData();
            }
        }
    }

    public function deleteUser($userId)
    {
        foreach ($this->user as $key => $value) {
            if ($value->getId() == $userId) {
                unset($this->user[$key]);
                $this->saveData();
            }
        }
    }
}