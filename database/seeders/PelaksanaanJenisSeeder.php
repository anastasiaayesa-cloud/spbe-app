<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ INI WAJIB


class PelaksanaanJenisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelaksanaan_jenis=[
            [
                'nama' => 'transport dari kantor - pelabuhan / bandara / tujuan',],
                [
                'nama' => 'pelabuhan bintan - pelabuhan batam / yg dituju / bandara',],
                [
                'nama' => 'tiket kapal / pesawat ',],
                [
                'nama' => 'transport dari pelabuhan ke tempat tujuan, sekolah / hotel / dinas dsb',],
                [
                'nama' => 'transport tujuan - pelabuhan / bandara',],
                [
                'nama' => 'transport pelabuhan - kantor',],
            ];

            DB::table('pelaksanaan_jenis')->insert($pelaksanaan_jenis);
    }
}
