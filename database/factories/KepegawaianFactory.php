<?php

namespace Database\Factories;
use App\Models\Kepegawaian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kepegawaian>
 */
class KepegawaianFactory extends Factory
{
       protected $model = Kepegawaian::class;
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nip' => $this->faker->unique()->numerify('##################'),
            'jabatan' => $this->faker->jobTitle(),
            'tempat_lahir' => $this->faker->city(),
            'tgl_lahir' => $this->faker->date('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'agama' => $this->faker->randomElement([
                'Islam',
                'Kristen Katolik',
                'Kristen Protestan',
                'Hindu',
                'Buddha',
                'Konghucu'
            ]),
            'instansi_id' => (string) $this->faker->numberBetween(1, 10),
            'hp' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'npwp' => $this->faker->numerify('##.###.###.#-###.###'),
            'bank_id' => (string) $this->faker->numberBetween(1, 5),
            'no_rek' => $this->faker->bankAccountNumber(),
            'is_bpmp' => $this->faker->randomElement(['Ya', 'Tidak']),
        ];
    }
}
