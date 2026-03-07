<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContentSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'company_id' => 1,
                'section_type_id' => 1,
                'title' => 'Welcome to Demo',
                'subtitle' => 'We build great things',
                'content' => 'This is the hero content for the demo site.',
                'translations' => json_encode(['es' => ['title' => 'Bienvenido a Demo', 'subtitle' => 'Construimos cosas geniales']]),
                'sort_order' => 1,
                'is_active' => 1,
            ],
        ];

        $this->db->table('content_sections')->insertBatch($sections);
    }
}
