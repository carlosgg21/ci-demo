<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        // Hacemos truncate para que el seeder sea idempotente
        $this->db->table('services')->truncate();

        $now = date('Y-m-d H:i:s');

        $services = [
            [
                'company_id'  => 1,
                'slug'        => 'web-development',
                'image'       => null,
                'icon'        => 'fa-code',
                'translations'=> json_encode([
                    'es' => ['name' => 'Desarrollo Web', 'description' => 'Construimos sitios web modernos y rápidos.'],
                    'en' => ['name' => 'Web Development', 'description' => 'We build fast and modern websites.'],
                ]),
                'sort_order'  => 1,
                'is_active'   => 1,
                'created_at'  => $now,
                'created_by'  => 1,
            ],
            [
                'company_id'  => 1,
                'slug'        => 'mobile-apps',
                'image'       => null,
                'icon'        => 'fa-mobile-alt',
                'translations'=> json_encode([
                    'es' => ['name' => 'Aplicaciones Móviles', 'description' => 'Desarrollamos apps para iOS y Android.'],
                    'en' => ['name' => 'Mobile Apps', 'description' => 'We develop apps for iOS and Android.'],
                ]),
                'sort_order'  => 2,
                'is_active'   => 1,
                'created_at'  => $now,
                'created_by'  => 1,
            ],
            [
                'company_id'  => 1,
                'slug'        => 'ui-ux-design',
                'image'       => null,
                'icon'        => 'fa-paint-brush',
                'translations'=> json_encode([
                    'es' => ['name' => 'Diseño UI/UX', 'description' => 'Diseños centrados en la experiencia de usuario.'],
                    'en' => ['name' => 'UI/UX Design', 'description' => 'Designs focused on user experience.'],
                ]),
                'sort_order'  => 3,
                'is_active'   => 1,
                'created_at'  => $now,
                'created_by'  => 1,
            ],
        ];

        $this->db->table('services')->insertBatch($services);
    }
}
