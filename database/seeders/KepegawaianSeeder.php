<?php

namespace Database\Seeders;
use App\Models\Kepegawaian;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KepegawaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          Kepegawaian::factory(20)->create();
    }
}
