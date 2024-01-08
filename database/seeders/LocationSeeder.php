<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lokasi awal (Musamus University)
        $baseLatitude = -8.5318299;
        $baseLongitude = 140.4145145;

        // Jumlah lokasi yang ingin ditambahkan
        $numberOfLocations = 5;

        // Jarak maksimum dari lokasi awal untuk menambahkan lokasi acak (dalam derajat)
        $maxDistance = 0.01;

        for ($i = 0; $i < $numberOfLocations; $i++) {
            // Menghasilkan koordinat acak di sekitar lokasi awal
            $latitude = $baseLatitude + ($maxDistance * (mt_rand(0, 100) / 100) * pow(-1, mt_rand(1, 2)));
            $longitude = $baseLongitude + ($maxDistance * (mt_rand(0, 100) / 100) * pow(-1, mt_rand(1, 2)));

            // Menyimpan data lokasi ke database menggunakan model
            Location::create([
                'latitude' => $latitude,
                'longitude' => $longitude,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
