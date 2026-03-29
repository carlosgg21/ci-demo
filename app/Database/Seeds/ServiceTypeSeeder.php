<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('service_types')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'denomination' => 'General',
                'slug'         => 'general',
                'description'  => 'Tipo de servicio por defecto',
                'is_active'    => 1,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
              [
                'denomination' => 'For Quote',
                'slug'         => 'for-quote',
                'description'  => 'Tipo de servicio para cotizaciones',
                'is_active'    => 1,
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        $this->db->table('service_types')->insertBatch($data);
    }
}
