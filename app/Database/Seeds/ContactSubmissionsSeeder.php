<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ContactSubmissionsSeeder extends Seeder
{
    public function run(): void
    {
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
