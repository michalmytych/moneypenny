<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesData = [
            ['code' => 'entertainment'],
            ['code' => 'education'],
            ['code' => 'transport'],
            ['code' => 'business'],
            ['code' => 'clothes'],
            ['code' => 'travels'],
            ['code' => 'health'],
            ['code' => 'house'],
            ['code' => 'hobby'],
            ['code' => 'food'],
            ['code' => 'work'],
        ];

        foreach ($categoriesData as $categoryData) {
            Category::firstOrCreate($categoryData);
        }
    }
}
