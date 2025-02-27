<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Category extends Entity
{
    protected $attributes = [
        'id' => null,
        'name' => null,
        'description' => null,
        'status' => null,
        'created_at' => null,
        'updated_at' => null
    ];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}
