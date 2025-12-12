<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PendidikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendidikans')->insert([
            ['nama_pendidikan' => 'SD/sederajat'],
            ['nama_pendidikan' => 'SMP/sederajat'],
            ['nama_pendidikan' => 'SMA/sederajat'],
            ['nama_pendidikan' => 'D-1/sederajat'],
            ['nama_pendidikan' => 'D-2/sederajat'],
            ['nama_pendidikan' => 'D-3/sederajat'],
            ['nama_pendidikan' => 'S-1/sederajat'],
            ['nama_pendidikan' => 'S-2/sederajat'],
            ['nama_pendidikan' => 'S-3/sederajat'],
        ]);
    }
}
