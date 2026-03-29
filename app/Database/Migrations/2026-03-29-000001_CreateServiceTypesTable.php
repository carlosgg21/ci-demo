<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServiceTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'denomination'=> ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'description' => ['type' => 'TEXT', 'null' => true],
            'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('denomination');
        $this->forge->addKey('is_active');
        $this->forge->createTable('service_types');
    }

    public function down()
    {
        $this->forge->dropTable('service_types');
    }
}
