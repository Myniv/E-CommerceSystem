<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthPermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'manage-all',
                'description' => 'Manage All Users',
            ],
            [
                'id' => 2,
                'name' => 'manage-products',
                'description' => 'Manage All Products',
            ],
            [
                'id' => 3,
                'name' => 'manage-profile',
                'description' => 'Manage User Profile',
            ],
        ];

        // Insert data into auth_groups table
        $this->db->table('auth_permissions')->insertBatch($data);
    }
}
