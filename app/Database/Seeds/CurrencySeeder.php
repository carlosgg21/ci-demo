<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'acronym' => 'ARS', 
                'name' => 'PESO ARGENTINO', 
                'sign' => '$', 
                'iso_numeric' => 32,
                'internal_code' => 1,
                'flag' => 'fi fi-ar fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'BOB', 
                'name' => 'BOLIVIANO', 
                'sign' => 'Bs', 
                'iso_numeric' => 68,
                'internal_code' => 2,
                'flag' => 'fi fi-bo fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'BRL', 
                'name' => 'REAL BRASILEÑO', 
                'sign' => 'R$', 
                'iso_numeric' => 986,
                'internal_code' => 3,
                'flag' => 'fi fi-br fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'CAD', 
                'name' => 'DÓLAR CANADIENSE', 
                'sign' => '$', 
                'iso_numeric' => 124,
                'internal_code' => 4,
                'flag' => 'fi fi-ca fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'CLP', 
                'name' => 'PESO CHILENO', 
                'sign' => '$', 
                'iso_numeric' => 152,
                'internal_code' => 5,
                'flag' => 'fi fi-cl fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'COP', 
                'name' => 'PESO COLOMBIANO', 
                'sign' => '$', 
                'iso_numeric' => 170,
                'internal_code' => 6,
                'flag' => 'fi fi-co fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'CRC', 
                'name' => 'COLÓN COSTARRICENSE', 
                'sign' => '₡', 
                'iso_numeric' => 188,
                'internal_code' => 7,
                'flag' => 'fi fi-cr fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'CUP', 
                'name' => 'PESO CUBANO', 
                'sign' => '$', 
                'iso_numeric' => 192,
                'internal_code' => 8,
                'flag' => 'fi fi-cu fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'DOP', 
                'name' => 'PESO DOMINICANO', 
                'sign' => '$', 
                'iso_numeric' => 214,
                'internal_code' => 9,
                'flag' => 'fi fi-do fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'EUR', 
                'name' => 'EURO', 
                'sign' => '€', 
                'iso_numeric' => 978,
                'internal_code' => 10,
                'flag' => 'fi fi-eu fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'GBP', 
                'name' => 'LIBRA ESTERLINA', 
                'sign' => '£', 
                'iso_numeric' => 826,
                'internal_code' => 11,
                'flag' => 'fi fi-gb fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'GTQ', 
                'name' => 'QUETZAL GUATEMALTECO', 
                'sign' => 'Q', 
                'iso_numeric' => 320,
                'internal_code' => 12,
                'flag' => 'fi fi-gt fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'HNL', 
                'name' => 'LEMPIRA HONDUREÑO', 
                'sign' => 'L', 
                'iso_numeric' => 340,
                'internal_code' => 13,
                'flag' => 'fi fi-hn fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'HTG', 
                'name' => 'GOURDE HAITIANO', 
                'sign' => 'G', 
                'iso_numeric' => 332,
                'internal_code' => 14,
                'flag' => 'fi fi-ht fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'MXN', 
                'name' => 'PESO MEXICANO', 
                'sign' => '$', 
                'iso_numeric' => 484,
                'internal_code' => 15,
                'flag' => 'fi fi-mx fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'PAB', 
                'name' => 'BALBOA PANAMEÑO', 
                'sign' => 'B/', 
                'iso_numeric' => 590,
                'internal_code' => 16,
                'flag' => 'fi fi-pa fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'PEN', 
                'name' => 'SOL PERUANO', 
                'sign' => 'S/', 
                'iso_numeric' => 604,
                'internal_code' => 17,
                'flag' => 'fi fi-pe fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'PYG', 
                'name' => 'GUARANÍ PARAGUAYO', 
                'sign' => '₲', 
                'iso_numeric' => 600,
                'internal_code' => 18,
                'flag' => 'fi fi-py fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'SVC', 
                'name' => 'COLON SALVADOREÑO', 
                'sign' => '₡', 
                'iso_numeric' => 222,
                'internal_code' => 19,
                'flag' => 'fi fi-sv fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'USD', 
                'name' => 'DÓLAR AMERICANO', 
                'sign' => '$', 
                'iso_numeric' => 840,
                'internal_code' => 20,
                'flag' => 'fi fi-us fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'UYU', 
                'name' => 'PESO URUGUAYO', 
                'sign' => '$', 
                'iso_numeric' => 858,
                'internal_code' => 21,
                'flag' => 'fi fi-uy fis',
                'status' => 'active'
            ],
            [
                'acronym' => 'VEF', 
                'name' => 'BOLIVAR VENEZOLANO', 
                'sign' => 'Bs', 
                'iso_numeric' => 937,
                'internal_code' => 22,
                'flag' => 'fi fi-ve fis',
                'status' => 'active'
            ],
        ];
        
        $now = date('Y-m-d H:i:s');
        foreach ($data as &$row) {
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
            $row['deleted_at'] = null;
        }
        
        $this->db->table('currencies')->insertBatch($data);
    }
}