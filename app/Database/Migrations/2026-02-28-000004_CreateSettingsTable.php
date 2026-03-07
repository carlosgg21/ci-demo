<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'key'        => ['type'=>'VARCHAR','constraint'=>100,'null'=>false],
            'value'      => ['type'=>'TEXT','null'=>false],
            'type'       => ['type'=>'VARCHAR','constraint'=>20,'default'=>'text'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','key'], false, true);
        $this->forge->addKey('company_id');
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
