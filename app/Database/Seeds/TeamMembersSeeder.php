<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamMembersSeeder extends Seeder
{
    public function run(): void
    {
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
