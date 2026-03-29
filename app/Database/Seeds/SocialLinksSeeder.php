<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SocialLinksSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('social_links')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $items = [
            [
                'entity_type' => 'company',
                'entity_id' => 1,
                'platform' => 'facebook',
                'url' => 'https://facebook.com/demo',
                'icon' => 'fab fa-facebook',
                'is_active' => 1,
            ],
            [
                'entity_type' => 'company',
                'entity_id' => 1,
                'platform' => 'twitter',
                'url' => 'https://twitter.com/demo',
                'icon' => 'fab fa-twitter',
                'is_active' => 1,
            ],
        ];

        $this->db->table('social_links')->insertBatch($items);
    }
}
