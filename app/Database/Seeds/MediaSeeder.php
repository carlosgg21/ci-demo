<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'entity_type' => 'company',
                'entity_id' => 1,
                'file_path' => 'uploads/logo.png',
                'type' => 'image',
                'alt_text' => 'Demo Logo',
                'is_active' => 1,
            ],
        ];

        $this->db->table('media')->insertBatch($items);
    }
}
