<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsDeletedToProducts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'is_deleted' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'updated_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'is_deleted');
    }
}
