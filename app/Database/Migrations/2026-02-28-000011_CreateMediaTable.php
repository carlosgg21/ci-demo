<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMediaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'entity_type' => ['type'=>'VARCHAR','constraint'=>50,'null'=>false],
            'entity_id'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'file_path'   => ['type'=>'VARCHAR','constraint'=>255,'null'=>false],
            'type'        => ['type'=>'VARCHAR','constraint'=>50,'null'=>true,'default'=>null],
            'alt_text'    => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'sort_order'  => ['type'=>'INT','constraint'=>11,'default'=>0],
            'is_active'   => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'  => ['type'=>'DATETIME','null'=>true],
            'updated_at'  => ['type'=>'DATETIME','null'=>true],
            'deleted_at'  => ['type'=>'DATETIME','null'=>true],
            'created_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['entity_type','entity_id']);
        $this->forge->addKey('sort_order');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('media');
    }

    public function down()
    {
        $this->forge->dropTable('media');
    }
}
