<?php
namespace App\Entities;

class User
{
    private $id;
    private $name;
    private $phone;
    private $email;
    private $address;
    private $sex;
    private $role;

    public function __construct($id, $name, $phone, $email, $address, $sex, $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->address = $address;
        $this->sex = $sex;
        $this->role = $role;
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPhone()
    {
        return $this->phone;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getAddress()
    {
        return $this->address;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getSex()
    {
        return $this->sex;
    }
    public function setSex($sex)
    {
        $this->sex = $sex;
    }
    
    public function getRole()
    {
        return $this->role;
    }
    public function setRole($role)
    {
        $this->role = $role;
    }

}