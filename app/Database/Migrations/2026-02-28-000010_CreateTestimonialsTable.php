<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestimonialsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'client_name'=> ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'client_position'=> ['type'=>'VARCHAR','constraint'=>150,'null'=>true,'default'=>null],
            'content'    => ['type'=>'TEXT','null'=>false],
            'translations'=> ['type'=>'JSON','null'=>false],
            'rating'     => ['type'=>'TINYINT','constraint'=>3,'unsigned'=>true,'null'=>true],
            'sort_order' => ['type'=>'INT','constraint'=>11,'default'=>0],
            'is_active'  => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','is_active']);
        $this->forge->addKey('sort_order');
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('testimonials');
    }

    public function down()
    {
        $this->forge->dropTable('testimonials');
    }
}
