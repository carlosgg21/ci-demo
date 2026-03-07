<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'company_id' => 1,
                'key'        => 'site_title',
                'value'      => 'Landing CMS Demo',
                'type'       => 'text',
            ],
        ];

        $this->db->table('settings')->insertBatch($settings);
    }
}
