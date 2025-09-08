<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Flood', 'description' => 'Risks related to flooding events.'],
            ['name' => 'Earthquake', 'description' => 'Risks arising from earthquakes.'],
            ['name' => 'Fire', 'description' => 'Risks related to fires and wildfires.'],
            ['name' => 'Epidemic', 'description' => 'Risks related to disease outbreaks.'],
            ['name' => 'Landslide', 'description' => 'Risks related to landslides and mudslides.'],
            ['name' => 'Others', 'description' => 'Risks impacting company image or stakeholder trust.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
