<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                $data = [
            [
                'id_user' => 1,
                'id_role' => 1,
                'username' => 'KriteriaSatu',
                'name' => 'Anggota Kriteria 1',
                'password' => Hash::make('Kriteria1'),
            ],
            [
                'id_user' => 2,
                'id_role' => 2,
                'username' => 'KriteriaDua',
                'name' => 'Anggota Kriteria 2',
                'password' => Hash::make('Kriteria2'),
            ],
            [
                'id_user' => 3,
                'id_role' => 3,
                'username' => 'KriteriaTiga',
                'name' => 'Anggota Kriteria 3',
                'password' => Hash::make('Kriteria3'),
            ],
            [
                'id_user' => 4,
                'id_role' => 4,
                'username' => 'KriteriaEmpat',
                'name' => 'Anggota Kriteria 4',
                'password' => Hash::make('Kriteria4'),
            ],
            [
                'id_user' => 5,
                'id_role' => 5,
                'username' => 'KriteriaLima',
                'name' => 'Anggota Kriteria 5',
                'password' => Hash::make('Kriteria5'),
            ],
            [
                'id_user' => 6,
                'id_role' => 6,
                'username' => 'KriteriaEnam',
                'name' => 'Anggota Kriteria 6',
                'password' => Hash::make('Kriteria6'),
            ],
            [
                'id_user' => 7,
                'id_role' => 7,
                'username' => 'KriteriaTujuh',
                'name' => 'Anggota Kriteria 7',
                'password' => Hash::make('Kriteria7'),
            ],
            [
                'id_user' => 8,
                'id_role' => 8,
                'username' => 'KriteriaDelapan',
                'name' => 'Anggota Kriteria 8',
                'password' => Hash::make('Kriteria8'),
            ],
            [
                'id_user' => 9,
                'id_role' => 9,
                'username' => 'KriteriaSembilan',
                'name' => 'Anggota Kriteria 9',
                'password' => Hash::make('Kriteria9'),
            ],
            [
                'id_user' => 10,
                'id_role' => 10,
                'username' => 'kpskjr',
                'name' => 'KPS / Kajur',
                'password' => Hash::make('KPSKajur'),
            ],
            [
                'id_user' => 11,
                'id_role' => 11,
                'username' => 'dirkjm',
                'name' => 'Direktur / KJM',
                'password' => Hash::make('DirekturKJM'),
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}
