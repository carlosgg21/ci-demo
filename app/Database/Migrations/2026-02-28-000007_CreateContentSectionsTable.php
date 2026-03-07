<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateContentSectionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'company_id'      => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'section_type_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>false],
            'title'           => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'subtitle'        => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'content'         => ['type'=>'TEXT','null'=>true],
            'button_text'     => ['type'=>'VARCHAR','constraint'=>100,'null'=>true,'default'=>null],
            'translations'    => ['type'=>'JSON','null'=>false],
            'button_link'     => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'metadata'        => ['type'=>'JSON','null'=>true],
            'sort_order'      => ['type'=>'INT','constraint'=>11,'default'=>0],
            'is_active'       => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'      => ['type'=>'DATETIME','null'=>true],
            'updated_at'      => ['type'=>'DATETIME','null'=>true],
            'deleted_at'      => ['type'=>'DATETIME','null'=>true],
            'created_by'      => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'      => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['company_id','is_active']);
        $this->forge->addKey('sort_order');
        $this->forge->addForeignKey('company_id','companies','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('section_type_id','section_types','id','RESTRICT','CASCADE');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('content_sections');
    }

    public function down()
    {
        $this->forge->dropTable('content_sections');
    }
}
