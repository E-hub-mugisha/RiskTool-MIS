<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $regions = [
            'Kigali City',
            'Northern Province',
            'Southern Province',
            'Eastern Province',
            'Western Province',
        ];

        foreach ($regions as $region) {
            Region::firstOrCreate(['name' => $region]);
        }
    }
}
