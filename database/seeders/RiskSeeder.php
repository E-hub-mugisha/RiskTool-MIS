<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Risk;
use App\Models\Department;
use App\Models\Category;
use App\Models\Region;

class RiskSeeder extends Seeder
{
    public function run(): void
    {
        // Step 1: Seed regions
        $regions = [
            'Kigali City',
            'Northern Province',
            'Southern Province',
            'Eastern Province',
            'Western Province',
        ];

        foreach ($regions as $regionName) {
            Region::firstOrCreate(['name' => $regionName]);
        }

        // Step 2: Seed categories
        $categories = [
            ['name' => 'Flood', 'description' => 'Risks related to flooding events.'],
            ['name' => 'Earthquake', 'description' => 'Risks arising from earthquakes.'],
            ['name' => 'Fire', 'description' => 'Risks related to fires and wildfires.'],
            ['name' => 'Epidemic', 'description' => 'Risks related to disease outbreaks.'],
            ['name' => 'Landslide', 'description' => 'Risks related to landslides and mudslides.'],
            ['name' => 'Others', 'description' => 'Other risks affecting safety, economy or reputation.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // Step 3: Create sample risks for each region
        $likelihoods = ['Low', 'Medium', 'High'];
        $impacts = ['Low', 'Medium', 'High'];

        foreach (Region::all() as $region) {
            foreach (Category::all() as $category) {
                $likelihood = $likelihoods[array_rand($likelihoods)];
                $impact = $impacts[array_rand($impacts)];

                $risk = Risk::create([
                    'title' => $category->name . ' Risk in ' . $region->name,
                    'description' => 'Potential ' . strtolower($category->name) . ' issue reported in ' . $region->name,
                    'region_id' => $region->id,
                    'category_id' => $category->id,
                    'likelihood' => $likelihood,
                    'impact' => $impact,
                    'level' => 'Pending',
                    'status' => 'Pending',
                ]);

                // Auto-calc level
                $risk->update([
                    'level' => $risk->calculateRiskLevel()
                ]);
            }
        }
    }
}
