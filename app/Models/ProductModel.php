<?php

namespace App\Models;

use App\Libraries\DataParams;
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
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'required|min_length[3]|max_length[255]',
        'price' => 'required|decimal|greater_than[0]',
        'stock' => 'required|integer|greater_than_equal_to[0]',
        'category_id' => 'required',
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
            'decimal' => 'The price must be a number.',
            'greater_than' => 'The price must be greater than 0.'
        ],
        "category_id" => [
            'required' => 'The category_id field is required.',
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


    public function getActiveProducts()
    {
        return $this->where('status', "Active")->findAll();
    }

    public function getLowStockProducts()
    {
        return $this->where("stock <=", "10")->findAll();
    }
    public function getOnSaleProducts()
    {
        return $this->where("is_sale =", "True")->findAll();
    }

    public function getProductsByCategory($category_id)
    {
        return $this->where("category_id", $category_id)->findAll();
    }

    public function getTotalProducts()
    {
        return $this->countAllResults();
    }

    public function getProductWithCategoriesAndImagePrimary()
    {
        return $this->select('products.*, categories.name as category_name, product_images.image_path as image_path')
            ->join('categories', 'categories.id = products.category_id', 'left')
            ->join('product_images', "product_images.product_id = products.id AND product_images.is_primary = 'true'", 'left');
    }

    public function getProductWithCategories()
    {
        return $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', );
    }

    public function getFilteredProducts(DataParams $params)
    {
        $this->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id');

        if (!empty($params->search)) {
            $this->groupStart()
                ->like('products.name', $params->search, 'both', null, true)
                ->orLike('products.description', $params->search, 'both', null, true)
                ->orLike('products.status', $params->search, 'both', null, true)
                ->groupEnd();
        }

        $filterableFields = ['category_id', 'status'];
        foreach ($params->filters as $field => $value) {
            if (in_array($field, $filterableFields) && $value !== '' && $value !== null) {
                $this->where("products.$field", $value);
            }
        }

        $allowedSortColumns = ['id', 'name', 'description', 'price', 'stock', 'status', 'category_id', 'category_name', 'created_at'];
        $sort = in_array($params->sort, $allowedSortColumns) ? $params->sort : 'id';
        $order = ($params->order === 'desc') ? 'desc' : 'asc';

        $this->orderBy($sort, $order);
        $result = [
            'products' => $this->paginate($params->perPage, 'products', $params->perPage),
            'pager' => $this->pager,
            'total' => $this->countAllResults(false),
        ];

        return $result;
    }

    public function getAllStatus()
    {
        $statuses = $this->select('status')->distinct()->findAll();
        return array_column($statuses, 'status');
    }

    public function getAllCategories()
    {
        $categories = $this->select('products.category_id, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->distinct()->findAll();

        return array_column($categories, 'categories');
    }

}
