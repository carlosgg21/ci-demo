<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactSubmissionsSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('contact_submissions')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $items = [
            [
                'company_id' => 1,
                'name' => 'Visitor',
                'email' => 'visitor@example.com',
                'message' => 'Hello, I am interested in your services.',
                'source' => 'contact_page',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('contact_submissions')->insertBatch($items);
    }
}
