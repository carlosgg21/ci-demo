<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LocalesSeeder extends Seeder
{
    public function run(): void
    {
        // asume que la compañia de id 1 existe
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
        ];

        $this->db->table('locales')->insertBatch($data);
    }
}
