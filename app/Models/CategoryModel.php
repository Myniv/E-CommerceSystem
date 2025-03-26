<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\Category::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'description',
        'status',
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
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[3]|max_length[500]',
        'status' => 'required|min_length[3]|max_length[255]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required.',
            'min_length' => 'The name must be at least 3 characters long.',
            'max_length' => 'The name must not exceed 255 characters.'
        ],
        'description' => [
            'required' => 'The description field is required.',
            'min_length' => 'The description must be at least 3 characters long.',
            'max_length' => 'The description must not exceed 500 characters.'
        ],
        'status' => [
            'required' => 'The status field is required.',
            'min_length' => 'The status must be at least 3 characters long.',
            'max_length' => 'The status must not exceed 255 characters.'
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

    public function getProductPercentageByCategory()
    {
        return $this
            ->select('categories.name AS category_name, COUNT(products.id) AS product_count, 
                 (COUNT(products.id) * 100.0 / (SELECT COUNT(*) FROM products)) AS percentage')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->groupBy('categories.id, categories.name')
            ->orderBy('percentage', 'DESC')
            ->get()
            ->getResult();
    }
    public function get5HighestProductByCategory(){
        return $this
            ->select('categories.name AS category_name, COUNT(products.id) AS product_count')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->groupBy('categories.id, categories.name')
            ->orderBy('product_count', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();
    }
}
