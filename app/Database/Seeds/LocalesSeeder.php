<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocalesSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('locales')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $data = [
            [
                'company_id' => 1,
                'code'       => 'en',
                'name'       => 'English',
                'is_default' => 1,
                'is_active'  => 1,
            ],
            [
                'company_id' => 1,
                'code'       => 'es',
                'name'       => 'Español',
                'is_default' => 0,
                'is_active'  => 1,
            ],
            [
                'company_id' => 1,
                'code'       => 'fr',
                'name'       => 'French',
                'is_default' => 0,
                'is_active'  => 1,
            ],
              [
                'company_id' => 1,
                'code'       => 'de',
                'name'       => 'German',
                'is_default' => 0,
                'is_active'  => 0,
            ],
            [
                'company_id' => 1,
                'code'       => 'zh',
                'name'       => 'Chinese',
                'is_default' => 0,
                'is_active'  => 0,
            ],
                [
                'company_id' => 1,
                'code'       => 'ru',
                'name'       => 'Russian',
                'is_default' => 0,
                'is_active'  => 0,
            ],
            [
                'company_id' => 1,
                'code'       => 'pt',
                'name'       => 'Portuguese',
                'is_default' => 0,
                'is_active'  => 0,
            ],

        ];

        $this->db->table('locales')->insertBatch($data);
    }
}
