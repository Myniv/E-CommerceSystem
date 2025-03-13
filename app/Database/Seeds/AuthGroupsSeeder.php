<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AuthGroupsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Administrator',
                'description' => 'role Administrator',
            ],
            [
                'id' => 2,
                'name' => 'Product Manager',
                'description' => 'role Product Manager',
            ],
            [
                'id' => 3,
                'name' => 'Customer',
                'description' => 'role Customer',
            ],
        ];

        // Insert data into auth_groups table
        $this->db->table('auth_groups')->insertBatch($data);
    }
}
