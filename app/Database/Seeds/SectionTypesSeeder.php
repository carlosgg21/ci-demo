<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SectionTypesSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('section_types')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $types = [
            ['key' => 'hero', 'name' => 'Hero'],
            ['key' => 'features', 'name' => 'Features'],
            ['key' => 'testimonials', 'name' => 'Testimonials'],
            ['key' => 'team', 'name' => 'Team'],
        ];

        $this->db->table('section_types')->insertBatch($types);
    }
}
