<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContactSubmissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'name'        => ['type'=>'VARCHAR','constraint'=>150,'null'=>true,'default'=>null],
            'email'       => ['type'=>'VARCHAR','constraint'=>150,'null'=>true,'default'=>null],
            'phone'       => ['type'=>'VARCHAR','constraint'=>30,'null'=>true,'default'=>null],
            'message'     => ['type'=>'TEXT','null'=>true],
            'source'      => ['type'=>'VARCHAR','constraint'=>50,'null'=>true,'default'=>null],
            'ip_address'  => ['type'=>'VARCHAR','constraint'=>45,'null'=>true,'default'=>null],
            'is_read'     => ['type'=>'TINYINT','constraint'=>1,'default'=>0],
            'created_at'  => ['type'=>'DATETIME','null'=>true],
            'deleted_at'  => ['type'=>'DATETIME','null'=>true],
            'created_by'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','is_read']);
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('contact_submissions');
    }

    public function down()
    {
        $this->forge->dropTable('contact_submissions');
    }
}
