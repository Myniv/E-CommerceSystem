<?php
namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Product extends Entity
{
    protected $attributes = [
        "id" => null,
        "name" => null,
        "description" => null,
        "price" => null,
        "stock" => null,
        "category_id" => null,
        "status" => null,
        "is_new" => null,
        "is_sale" => null,
        'created_at' => null,
        'updated_at' => null,
        'deleted_at' => null,
    ];

    protected $casts = [
        "id" => "integer",
        "name" => "string",
        "description" => "string",
        "price" => "float",
        "stock" => "integer",
        "category_id" => "integer",
        "status" => "string",
        "is_new" => "string",
        "is_sale" => "string",
        "created_at" => "datetime",
        "updated_at" => "datetime",
        "deleted_at" => "datetime",
    ];

    public function getFormattedPrice()
    {
        return "Rp " . number_format($this->attributes["price"], 2, ',', '.');
    }

    public function isInStock()
    {
        if ($this->attributes['stock'] > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getStatus()
    {
        return $this->attributes['status'];
    }

    public function isSale()
    {
        if ($this->attributes['is_sale'] == true) {
            return true;
            // return "The product is on SALE";
        } else {
            return false;
            // return "The product is not on SALE";
        }
    }

}