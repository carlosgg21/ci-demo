<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSectionTypesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'key'         => ['type'=>'VARCHAR','constraint'=>50,'null'=>false],
            'name'        => ['type'=>'VARCHAR','constraint'=>100,'null'=>false],
            'description' => ['type'=>'TEXT','null'=>true],
            'created_at'  => ['type'=>'DATETIME','null'=>true],
            'updated_at'  => ['type'=>'DATETIME','null'=>true],
            'deleted_at'  => ['type'=>'DATETIME','null'=>true],
            'created_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('key');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('section_types');
    }

    public function down()
    {
        $this->forge->dropTable('section_types');
    }
}
