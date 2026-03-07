<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SectionTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['key' => 'hero', 'name' => 'Hero'],
            ['key' => 'features', 'name' => 'Features'],
            ['key' => 'testimonials', 'name' => 'Testimonials'],
            ['key' => 'team', 'name' => 'Team'],
        ];

        $this->db->table('section_types')->insertBatch($types);
    }
}
