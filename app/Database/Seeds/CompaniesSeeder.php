<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'name'       => 'Demo Company',
            'slug'       => 'demo-company',
            'email'      => 'info@demo.com',
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 1, // administrador
        ];

        $this->db->table('companies')->insert($data);
    }
}
