<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pasien;
use Faker\Factory as Faker;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        $petugasIds = User::where('role', 'petugas')->pluck('id')->toArray();

        if (count($petugasIds) < 2) {
            echo "Minimal harus ada 2 petugas";
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            // Pasien 0-4 ke petugasIds[0], pasien 5-9 ke petugasIds[1]
            $petugasId = $i < 5 ? $petugasIds[0] : $petugasIds[1];

            Pasien::create([
                'nik' => $faker->unique()->numerify('##########'),
                'nama' => $faker->name(),
                'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'alamat' => $faker->address(),
                'nama_ortu' => $faker->name('male'),
                'foto' => null,
                'petugas_id' => $petugasId,
            ]);
        }

    }
}
