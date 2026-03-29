<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('testimonials')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $items = [
            [
                'company_id' => 1,
                'client_name' => 'John Doe',
                'content' => 'Great service!',
                'translations' => json_encode(['es' => ['content' => '¡Excelente servicio!']]),
                'is_active' => 1,
            ],
        ];

        $this->db->table('testimonials')->insertBatch($items);
    }
}
