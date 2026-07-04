<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsDeletedToCategoriesAndSuppliers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('categories', [
            'is_deleted' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'created_at',
            ],
        ]);

        $this->forge->addColumn('suppliers', [
            'is_deleted' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'created_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('categories', 'is_deleted');
        $this->forge->dropColumn('suppliers', 'is_deleted');
    }
}
