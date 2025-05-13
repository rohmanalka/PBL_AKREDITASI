<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id_kriteria' => 1,
                'nama_kriteria' => 'Kriteria 1 - Visi, Misi, Tujuan, dan Strategi'
            ],
            [
                'id_kriteria' => 2,
                'nama_kriteria' => 'Kriteria 2 - Tata Kelola, Tata Pamong, dan Kerjasama',
            ],
            [
                'id_kriteria' => 3,
                'nama_kriteria' => 'Kriteria 3 - Mahasiswa',
            ],
            [
                'id_kriteria' => 4,
                'nama_kriteria' => 'Kriteria 4 - Sumber Daya Manusia',
            ],
            [
                'id_kriteria' => 5,
                'nama_kriteria' => 'Kriteria 5 - Keuangan, Sarana, dan Prasarana',
            ],
            [
                'id_kriteria' => 6,
                'nama_kriteria' => 'Kriteria 6 - Pendidikan',
            ],
            [
                'id_kriteria' => 7,
                'nama_kriteria' => 'Kriteria 7 - Penelitian',
            ],
            [
                'id_kriteria' => 8,
                'nama_kriteria' => 'Kriteria 8 - Pengabdian kepada Masyarakat',
            ],
            [
                'id_kriteria' => 9,
                'nama_kriteria' => 'Kriteria 9 - Luaran dan Capaian Tridharma',
            ]
        ];

        DB::table('m_kriteria')->insert($data);
    }
}
