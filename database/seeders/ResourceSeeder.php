<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Region;
use Carbon\Carbon;

class ResourceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['item' => 'Rice', 'unit' => 'kg'],
            ['item' => 'Beans', 'unit' => 'kg'],
            ['item' => 'Maize Flour', 'unit' => 'kg'],
            ['item' => 'Cooking Oil', 'unit' => 'liters'],
            ['item' => 'Bottled Water', 'unit' => 'liters'],
            ['item' => 'First Aid Kits', 'unit' => 'packs'],
            ['item' => 'Blankets', 'unit' => 'pieces'],
            ['item' => 'Tents', 'unit' => 'pieces'],
            ['item' => 'Mosquito Nets', 'unit' => 'pieces'],
            ['item' => 'Medical Supplies', 'unit' => 'packs'],
        ];

        $regions = Region::pluck('id', 'name'); // assumes you seeded regions already

        foreach ($items as $item) {
            foreach ($regions as $regionName => $regionId) {
                Resource::create([
                    'item' => $item['item'],
                    'quantity' => rand(50, 500), // random stock levels
                    'unit' => $item['unit'],
                    'expiry_date' => in_array($item['unit'], ['kg', 'liters', 'packs']) 
                        ? Carbon::now()->addMonths(rand(6, 24)) 
                        : null, // no expiry for tents/blankets etc.
                    'region_id' => $regionId,
                ]);
            }
        }
    }
}
