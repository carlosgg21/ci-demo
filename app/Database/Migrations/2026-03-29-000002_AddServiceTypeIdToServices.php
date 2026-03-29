<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddServiceTypeIdToServices extends Migration
{
    public function up()
    {
        $this->forge->addColumn('services', [
            'service_type_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'default'    => null,
                'after'      => 'company_id',
            ],
        ]);

        $this->db->query('ALTER TABLE services ADD CONSTRAINT fk_services_service_type FOREIGN KEY (service_type_id) REFERENCES service_types(id) ON DELETE SET NULL ON UPDATE CASCADE');
        $this->db->query('CREATE INDEX idx_services_service_type_id ON services (service_type_id)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE services DROP FOREIGN KEY fk_services_service_type');
        $this->forge->dropColumn('services', 'service_type_id');
    }
}
