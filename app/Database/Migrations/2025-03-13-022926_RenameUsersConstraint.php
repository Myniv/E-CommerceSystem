<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameUsersConstraint extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users_ecommerce RENAME CONSTRAINT pk_users TO pk_users_ecommerce;");

    }

    public function down()
    {
        $this->db->query("ALTER TABLE users_ecommerce RENAME CONSTRAINT pk_users_ecommerce TO pk_users;");
    }
}
