<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run(): void
    {
        // Primera: Usuarios (sin dependencias)
        $this->call('UsersSeeder');
        
        // Segunda: Compañías (depende de usuarios)
        $this->call('CompaniesSeeder');
        
        // Tercera: Locales (depende de compañías)
        $this->call('LocalesSeeder');
        
        // Cuarta: Configuraciones (depende de compañías)
        $this->call('SettingsSeeder');
        
        // Quinta: Tipos de sección (sin dependencias)
        $this->call('SectionTypesSeeder');
        
        // Sexta: Secciones de contenido (depende de tipos y compañías)
        $this->call('ContentSectionsSeeder');
        
        // Séptima: Enlaces sociales (depende de compañías)
        $this->call('SocialLinksSeeder');
        
        // Octava: Miembros del equipo (depende de compañías)
        $this->call('TeamMembersSeeder');
        
        // Novena: Testimonios (depende de compañías)
        $this->call('TestimonialsSeeder');
        
        // Décima: Medios
        $this->call('MediaSeeder');
        
        // Undécima: Envíos de contacto (depende de compañías)
        $this->call('ContactSubmissionsSeeder');

        $this->call('ServiceSeeder');

        $this->call('CurrencySeeder');

        // Si quieres que el seeder sea idempotente, puedes vaciar las tablas
        // aquí antes de insertar (o hacerlo en cada clase individual).
        // Por ejemplo:
        // $this->db->table('users')->truncate();
        // ... etc.
    }
}
