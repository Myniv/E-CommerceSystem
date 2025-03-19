<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateIsPrimaryToBoolean extends Migration
{
    public function up()
    {
        // Convert existing VARCHAR values to BOOLEAN
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary TYPE BOOLEAN 
                          USING (is_primary::BOOLEAN)");

        // Ensure the column has a default value (optional)
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary SET DEFAULT FALSE");

        // Make sure NULL values are replaced with FALSE
        $this->db->query("UPDATE product_images 
                          SET is_primary = FALSE 
                          WHERE is_primary IS NULL");
    }

    public function down()
    {
        // Revert back to VARCHAR if needed
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary TYPE VARCHAR(100) 
                          USING (is_primary::VARCHAR)");

        // Remove default value
        $this->db->query("ALTER TABLE product_images 
                          ALTER COLUMN is_primary DROP DEFAULT");
    }
}
