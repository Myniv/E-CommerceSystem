<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\Product::class;
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'name',
        'description',
        'price',
        'stock',
        'category_id',
        'status',
        'is_new',
        'is_sale'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|numeric|greater_than[0]',
        'stock' => 'required|integer|grater_than_equal_to[0]',
        'category_id' => 'required|integer',
        'status' => 'required|in_list[Active,Inactive]',
        'is_new' => 'required|in_list[True,False]',
        'is_sale' => 'required|in_list[True,False]'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required.',
            'min_length' => 'The name must be at least 3 characters long.',
            'max_length' => 'The name cannot exceed 255 characters.'
        ],
        'description' => [
            'required' => 'The description field is required.',
            'min_length' => 'The description must be at least 3 characters long.',
            'max_length' => 'The description cannot exceed 255 characters.'
        ],
        'price' => [
            'required' => 'The price field is required.',
            'numeric' => 'The price must be a number.',
            'greater_than' => 'The price must be greater than 0.'
        ],
        'stock' => [
            'required' => 'The stock field is required',
            'integer' => 'The price must be a number.',
            'grater_than_equal_to' => 'The stock must be greater than or equal to 0.'
        ],
        'status' => [
            'required' => 'The status field is required.',
            'in_list' => 'The status must be either "Active" or "Inactive".'
        ],
        'is_new' => [
            'required' => 'The is_new field is required.',
            'in_list' => 'The is_new must be either "True" or "False".'
        ],
        'is_sale' => [
            'required' => 'The is_sale field is required.',
            'in_list' => 'The is_sale must be either "True" or "False".'
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


    public function findActiveProducts()
    {
        return $this->where('status', "Active")->findAll();
    }

    public function getLowStockProducts()
    {
        return $this->where("stock <=", "10")->findAll();
    }

    public function getProductsByCategory($category_id)
    {
        return $this->where("category_id", $category_id)->findAll();
    }

    public function countTotalProducts()
    {
        return count($this->findAll());
    }

}
