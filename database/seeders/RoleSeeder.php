<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_role' => 1,
                'id_kriteria' => 1,
                'role_kode' => 'KRIT1',
                'role_name' => 'Kriteria 1'
            ],
            [
                'id_role' => 2,
                'id_kriteria' => 2,
                'role_kode' => 'KRIT2',
                'role_name' => 'Kriteria 2'
            ],
            [
                'id_role' => 3,
                'id_kriteria' => 3,
                'role_kode' => 'KRIT3',
                'role_name' => 'Kriteria 3'
            ],
            [
                'id_role' => 4,
                'id_kriteria' => 4,
                'role_kode' => 'KRIT4',
                'role_name' => 'Kriteria 4'
            ],
            [
                'id_role' => 5,
                'id_kriteria' => 5,
                'role_kode' => 'KRIT5',
                'role_name' => 'Kriteria 5'
            ],
            [
                'id_role' => 6,
                'id_kriteria' => 6,
                'role_kode' => 'KRIT6',
                'role_name' => 'Kriteria 6'
            ],
            [
                'id_role' => 7,
                'id_kriteria' => 7,
                'role_kode' => 'KRIT7',
                'role_name' => 'Kriteria 7'
            ],
            [
                'id_role' => 8,
                'id_kriteria' => 8,
                'role_kode' => 'KRIT8',
                'role_name' => 'Kriteria 8'
            ],
            [
                'id_role' => 9,
                'id_kriteria' => 9,
                'role_kode' => 'KRIT9',
                'role_name' => 'Kriteria 9'
            ],
            [
                'id_role' => 10,
                'id_kriteria' => null,
                'role_kode' => 'KPSKJR',
                'role_name' => 'KPS / Kajur'
            ],
            [
                'id_role' => 11,
                'id_kriteria' => null,
                'role_kode' => 'DIRKJM',
                'role_name' => 'Direktur / KJM'
            ],
        ];

        DB::table('m_role')->insert($data);
    }
}
