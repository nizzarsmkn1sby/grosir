<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'children' => [
                    ['name' => 'Smartphone'],
                    ['name' => 'Laptop'],
                    ['name' => 'Aksesoris Elektronik'],
                ]
            ],
            [
                'name' => 'Fashion',
                'children' => [
                    ['name' => 'Pakaian Pria'],
                    ['name' => 'Pakaian Wanita'],
                    ['name' => 'Sepatu'],
                ]
            ],
            [
                'name' => 'Makanan & Minuman',
                'children' => [
                    ['name' => 'Makanan Ringan'],
                    ['name' => 'Minuman'],
                    ['name' => 'Bahan Pokok'],
                ]
            ],
            [
                'name' => 'Peralatan Rumah Tangga',
                'children' => [
                    ['name' => 'Peralatan Dapur'],
                    ['name' => 'Furniture'],
                    ['name' => 'Dekorasi'],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name' => $categoryData['name'],
            ]);

            if (isset($categoryData['children'])) {
                foreach ($categoryData['children'] as $child) {
                    Category::create([
                        'name' => $child['name'],
                        'parent_id' => $parent->id,
                    ]);
                }
            }
        }
    }
}
