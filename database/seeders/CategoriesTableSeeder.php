<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            ['code' => 'entertainment', 'color_hex' => '#eab308'],
            ['code' => 'education', 'color_hex' => '#0369a1'],
            ['code' => 'transport', 'color_hex' => '#6366f1'],
            ['code' => 'business', 'color_hex' => '#14b8a6'],
            ['code' => 'clothes', 'color_hex' => '#fca5a5'],
            ['code' => 'travels', 'color_hex' => '#84cc16'],
            ['code' => 'health', 'color_hex' => '#9d174d'],
            ['code' => 'house', 'color_hex' => '#f59e0b'],
            ['code' => 'hobby', 'color_hex' => '#818cf8'],
            ['code' => 'food', 'color_hex' => '#15803d'],
            ['code' => 'work', 'color_hex' => '#64748b'],
        ];

        foreach ($categoriesData as $categoryData) {
            Category::firstOrCreate($categoryData);
        }
    }
}
