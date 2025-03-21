<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateIsPrimaryProductImageDefault extends Migration
{
    public function up()
    {
        // Ensure NULL values are replaced with FALSE before altering the column type
        $this->db->query("UPDATE product_images 
                          SET is_primary = 'false' 
                          WHERE is_primary IS NULL OR is_primary NOT IN ('true', 'false')");

        // Convert the is_primary column from VARCHAR to BOOLEAN
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary TYPE BOOLEAN 
                          USING (is_primary::BOOLEAN)");

        // Set the default value of is_primary to FALSE
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary SET DEFAULT FALSE");

        // Ensure any remaining NULL values are replaced with FALSE
        $this->db->query("UPDATE product_images 
                          SET is_primary = FALSE 
                          WHERE is_primary IS NULL");
    }

    public function down()
    {
        // Convert BOOLEAN back to VARCHAR
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary TYPE VARCHAR(100) 
                          USING (is_primary::TEXT)");

        // Remove default value
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary DROP DEFAULT");
    }

}
