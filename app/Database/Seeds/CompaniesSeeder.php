<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('companies')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

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
