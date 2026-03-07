<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name'          => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'slug'          => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'legal_name'    => ['type'=>'VARCHAR','constraint'=>150,'null'=>true,'default'=>null],
            'tax_id'        => ['type'=>'VARCHAR','constraint'=>50,'null'=>true,'default'=>null],
            'email'         => ['type'=>'VARCHAR','constraint'=>150,'null'=>true,'default'=>null],
            'phone'         => ['type'=>'VARCHAR','constraint'=>50,'null'=>true,'default'=>null],
            'mobile'        => ['type'=>'VARCHAR','constraint'=>20,'null'=>true,'default'=>null],
            'address'       => ['type'=>'TEXT','null'=>true],
            'city'          => ['type'=>'VARCHAR','constraint'=>100,'null'=>true,'default'=>null],
            'state'         => ['type'=>'VARCHAR','constraint'=>100,'null'=>true,'default'=>null],
            'country'       => ['type'=>'VARCHAR','constraint'=>100,'null'=>true,'default'=>null],
            'postal_code'   => ['type'=>'VARCHAR','constraint'=>20,'null'=>true,'default'=>null],
            'logo'          => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'favicon'       => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'website'       => ['type'=>'VARCHAR','constraint'=>255,'null'=>true,'default'=>null],
            'created_at'    => ['type'=>'DATETIME','null'=>true],
            'updated_at'    => ['type'=>'DATETIME','null'=>true],
            'deleted_at'    => ['type'=>'DATETIME','null'=>true],
            'created_by'    => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by'    => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('slug');
        $this->forge->addForeignKey('created_by','users','id','SET NULL','CASCADE');
        $this->forge->addForeignKey('updated_by','users','id','SET NULL','CASCADE');
        $this->forge->createTable('companies');
    }

    public function down()
    {
        $this->forge->dropTable('companies');
    }
}
