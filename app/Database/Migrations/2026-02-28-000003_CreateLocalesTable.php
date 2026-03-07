<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLocalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'code'        => ['type'=>'VARCHAR','constraint'=>10,'null'=>false],
            'name'        => ['type'=>'VARCHAR','constraint'=>50,'null'=>false],
            'is_default'  => ['type'=>'TINYINT','constraint'=>1,'default'=>0],
            'is_active'   => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'  => ['type'=>'DATETIME','null'=>true],
            'updated_at'  => ['type'=>'DATETIME','null'=>true],
            'deleted_at'  => ['type'=>'DATETIME','null'=>true],
            'created_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','code'], false, true);
        $this->forge->addKey(['company_id','is_active']);
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('locales');
    }

    public function down()
    {
        $this->forge->dropTable('locales');
    }
}
