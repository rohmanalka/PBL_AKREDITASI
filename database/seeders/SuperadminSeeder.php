<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
                'id' => 1,
                'username' => 'superadmin',
                'password' => Hash::make('superadmin')
        ];
        
        DB::table('m_superadmin')->insert($data);
    }
}
