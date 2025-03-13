<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameUsersTable extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users RENAME TO users_ecommerce");

    }

    public function down()
    {
        $this->db->query("ALTER TABLE users RENAME TO users_ecommerce");
    }
}
