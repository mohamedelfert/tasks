<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Cat1',
            'Cat2',
            'Cat3',
            'Cat4',
            'Cat5',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
