<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugToServiceTypes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('service_types', [
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
                'default'    => '',
                'after'      => 'denomination',
            ],
        ]);

        $this->db->query('CREATE UNIQUE INDEX service_types_slug_unique ON service_types (slug)');
    }

    public function down()
    {
        $this->db->query('DROP INDEX service_types_slug_unique ON service_types');
        $this->forge->dropColumn('service_types', 'slug');
    }
}
