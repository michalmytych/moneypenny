<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction\Category;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('categories') as $categoryData) {
            Category::firstOrCreate($categoryData);
        }
    }
}
