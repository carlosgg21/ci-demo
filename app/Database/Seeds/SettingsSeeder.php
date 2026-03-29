<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('settings')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

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
