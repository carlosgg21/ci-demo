<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateServicesFullTable extends Migration
{
    public function up()
    {
        // this migration assumes the original simple services table may exist;
        // it's safer to drop and recreate, or alter fields. For now we'll recreate.
        $this->forge->dropTable('services', true);

        $this->forge->addField([
            'id'           => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'slug'         => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'name'         => ['type'=>'VARCHAR','constraint'=>200,'null'=>false],
            'description'  => ['type'=>'TEXT','null'=>true],
            'image'        => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'icon'         => ['type'=>'VARCHAR','constraint'=>100,'null'=>true,'default'=>null],
            'translations' => ['type'=>'JSON','null'=>true],
            'sort_order'   => ['type'=>'INT','constraint'=>11,'default'=>0],
            'is_active'    => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'   => ['type'=>'DATETIME','null'=>true],
            'updated_at'   => ['type'=>'DATETIME','null'=>true],
            'deleted_at'   => ['type'=>'DATETIME','null'=>true],
            'created_by'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'   => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','slug'], false, true);
        $this->forge->addKey(['company_id','is_active']);
        $this->forge->addKey('sort_order');
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('services');
    }

    public function down()
    {
        $this->forge->dropTable('services');
    }
}
