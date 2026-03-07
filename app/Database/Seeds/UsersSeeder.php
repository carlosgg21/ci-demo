<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        $data = [
            'username'   => 'admin',
            'email'      => 'admin@example.com',
            'password'   => password_hash('admin', PASSWORD_DEFAULT),
            'role'       => 'super_admin',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);

        // puede añadir más registros faker si se desea
    }
}
