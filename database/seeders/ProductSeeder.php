<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 3; $i++) {
            $category = Category::query()->create([
                'title' => fake()->name(),
                'description' => fake()->text(200),
            ]);
            for ($j = 0; $j < 10; $j++) {
                Product::query()->create([
                    'name'          => fake()->name(),
                    'price'         => rand(200, 3700) * 1.00,
                    'in_stock'      => boolval(rand(0, 2)),
                    'rating'        => rand(1, 5),
                    'category_id'   => $category->id,
                    'created_at'    => now(),
                ]);
            }
        }
    }
}
