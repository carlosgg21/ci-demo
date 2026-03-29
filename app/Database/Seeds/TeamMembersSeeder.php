<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    public function run(): void
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('team_members')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $members = [
            [
                'company_id' => 1,
                'name' => 'Alice Johnson',
                'position' => 'CEO',
                'bio' => 'Founder and CEO',
                'translations' => json_encode(['es' => ['name' => 'Alicia Johnson', 'position' => 'CEO']]),
                'is_active' => 1,
            ],
        ];

        $this->db->table('team_members')->insertBatch($members);
    }
}
