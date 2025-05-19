<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pasien;
use App\Models\Imunisasi;

class ImunisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisVaksin = ['BCG', 'Polio', 'DPT', 'Hepatitis B', 'Campak'];

        Pasien::take(5)->get()->each(function ($pasien) use ($jenisVaksin) {
            foreach (array_slice($jenisVaksin, 0, rand(3, 5)) as $vaksin) {
                Imunisasi::create([
                    'pasien_id' => $pasien->id,
                    'jenis_vaksin' => $vaksin,
                    'tanggal' => $pasien->tanggal_lahir->copy()->addMonths(rand(1, 12)),
                    'status' => 'selesai',
                ]);
            }
        });

    }
}
