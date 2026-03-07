<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCurrenciesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'acronym' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => false,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'sign' => [
                'type'       => 'VARCHAR',
                'constraint' => 5,
                'null'       => true,
            ],
            'iso_numeric' => [
                'type'       => 'INT',
                'constraint' => 3,
                'null'       => true,
            ],
            'internal_code' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'flag' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        // Primary Key
        $this->forge->addPrimaryKey('id');
        
        // Índices
        $this->forge->addUniqueKey('acronym');
        $this->forge->addUniqueKey('iso_numeric');
        $this->forge->addKey('internal_code');
        $this->forge->addKey('status');
        
        // Opciones de tabla para MariaDB
        $this->forge->addKey('created_at');
        
        $this->forge->createTable('currencies', true);
    }

    public function down()
    {
        $this->forge->dropTable('currencies', true);
    }
}