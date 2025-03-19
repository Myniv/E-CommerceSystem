<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table = 'product_images';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = \App\Entities\ProductImage::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id',
        'image_path',
        'is_primary',
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
        'product_id' => 'required|integer',
        'image_path' => 'required',
        'is_primary' => 'required',
    ];
    protected $validationMessages = [
        'product_id' => [
            'required' => 'The product id field is required.',
            'integer' => 'The product is must number.',
        ],
        'image_path' => [
            'required' => 'The image path field is required.',
        ],
        'is_primary' => [
            'required' => 'The is primary field is required.',
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

    public function getPrimaryImage($productId)
    {
        $this->select('image_path')->where('product_id =', $productId)
            ->where('is_primary', true)
            ->find();
    }
}
