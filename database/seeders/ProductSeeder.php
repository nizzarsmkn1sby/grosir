<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Elektronik - Smartphone
            ['name' => 'Samsung Galaxy S23', 'sku' => 'ELEC-SMRT-001', 'price' => 12500000, 'stock_qty' => 50, 'category' => 'Smartphone'],
            ['name' => 'iPhone 15 Pro', 'sku' => 'ELEC-SMRT-002', 'price' => 18000000, 'stock_qty' => 30, 'category' => 'Smartphone'],
            ['name' => 'Xiaomi 13T', 'sku' => 'ELEC-SMRT-003', 'price' => 6500000, 'stock_qty' => 100, 'category' => 'Smartphone'],
            
            // Elektronik - Laptop
            ['name' => 'ASUS ROG Strix G15', 'sku' => 'ELEC-LPTOP-001', 'price' => 22000000, 'stock_qty' => 25, 'category' => 'Laptop'],
            ['name' => 'MacBook Air M2', 'sku' => 'ELEC-LPTOP-002', 'price' => 16500000, 'stock_qty' => 20, 'category' => 'Laptop'],
            ['name' => 'Lenovo ThinkPad X1', 'sku' => 'ELEC-LPTOP-003', 'price' => 18500000, 'stock_qty' => 15, 'category' => 'Laptop'],
            
            // Fashion - Pakaian Pria
            ['name' => 'Kemeja Batik Pria', 'sku' => 'FASH-PRIA-001', 'price' => 250000, 'stock_qty' => 200, 'category' => 'Pakaian Pria'],
            ['name' => 'Celana Jeans Pria', 'sku' => 'FASH-PRIA-002', 'price' => 350000, 'stock_qty' => 150, 'category' => 'Pakaian Pria'],
            
            // Fashion - Sepatu
            ['name' => 'Sepatu Sneakers Nike', 'sku' => 'FASH-SHOE-001', 'price' => 1200000, 'stock_qty' => 80, 'category' => 'Sepatu'],
            ['name' => 'Sepatu Formal Pria', 'sku' => 'FASH-SHOE-002', 'price' => 650000, 'stock_qty' => 60, 'category' => 'Sepatu'],
            
            // Makanan & Minuman
            ['name' => 'Kopi Arabica 1kg', 'sku' => 'FOOD-BVRG-001', 'price' => 150000, 'stock_qty' => 500, 'category' => 'Minuman'],
            ['name' => 'Beras Premium 5kg', 'sku' => 'FOOD-BHAN-001', 'price' => 75000, 'stock_qty' => 1000, 'category' => 'Bahan Pokok'],
            ['name' => 'Minyak Goreng 2L', 'sku' => 'FOOD-BHAN-002', 'price' => 35000, 'stock_qty' => 800, 'category' => 'Bahan Pokok'],
            
            // Peralatan Rumah Tangga
            ['name' => 'Panci Set Stainless', 'sku' => 'HOME-KTCH-001', 'price' => 450000, 'stock_qty' => 100, 'category' => 'Peralatan Dapur'],
            ['name' => 'Meja Makan Kayu Jati', 'sku' => 'HOME-FURN-001', 'price' => 3500000, 'stock_qty' => 20, 'category' => 'Furniture'],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category'])->first();
            
            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'sku' => $productData['sku'],
                    'price' => $productData['price'],
                    'stock_qty' => $productData['stock_qty'],
                    'category_id' => $category->id,
                    'stock' => $productData['stock_qty'], // Use same value as stock_qty
                    'is_available' => true,
                ]);
            }
        }
    }
}
