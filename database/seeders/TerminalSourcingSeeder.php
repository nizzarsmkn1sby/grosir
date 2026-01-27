<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TerminalSourcingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Safe Deletion (Disable Foreign Keys)
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Premium Categories
        $categories = [
            'Industrial Logic' => [
                'Micro-controllers',
                'PLC Modules',
                'Logic Arrays'
            ],
            'Optic Photonics' => [
                'Laser Scanners',
                'Fiber Optics',
                'Vision Sensors'
            ],
            'Energy Systems' => [
                'Power Modules',
                'Lithium Batches',
                'Inverter Terminal'
            ],
            'Robotic Sourcing' => [
                'Actuator Arms',
                'Servo Drivers',
                'Sensorial Nodes'
            ]
        ];

        foreach ($categories as $parentName => $subCats) {
            $parent = Category::create(['name' => $parentName]);
            foreach ($subCats as $subName) {
                Category::create([
                    'name' => $subName,
                    'parent_id' => $parent->id
                ]);
            }
        }

        // 3. Premium Products with Curated Tech/Industrial Visuals
        $products = [
            // Industrial Logic
            [
                'name' => 'Quantum Logic Controller X1',
                'category' => 'PLC Modules',
                'price' => 4500000,
                'stock' => 150,
                'img' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&q=80&w=800',
                'sku' => 'LOGIC-QX1-001'
            ],
            [
                'name' => 'Array Terminal Node v.4',
                'category' => 'Logic Arrays',
                'price' => 2750000,
                'stock' => 300,
                'img' => 'https://images.unsplash.com/photo-1555664424-778a1e5e1b48?auto=format&fit=crop&q=80&w=800',
                'sku' => 'NODE-V4-LOGIC'
            ],
            // Optic Photonics
            [
                'name' => 'Photon Scanner Pro 8k',
                'category' => 'Laser Scanners',
                'price' => 12500000,
                'stock' => 45,
                'img' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&q=80&w=800',
                'sku' => 'PHOTON-8K-PRO'
            ],
            [
                'name' => 'Optic Fiber Hub 10G',
                'category' => 'Fiber Optics',
                'price' => 1500000,
                'stock' => 500,
                'img' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&q=80&w=800',
                'sku' => 'OPTIC-HUB-10G'
            ],
            // Energy Systems
            [
                'name' => 'Titanium Power Module',
                'category' => 'Power Modules',
                'price' => 8900000,
                'stock' => 25,
                'img' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&q=80&w=800',
                'sku' => 'PWR-TITAN-MOD'
            ],
            [
                'name' => 'Lithium Ion Batch X-200',
                'category' => 'Lithium Batches',
                'price' => 15000000,
                'stock' => 10,
                'img' => 'https://images.unsplash.com/photo-1568952433726-3896e3881c65?auto=format&fit=crop&q=80&w=800',
                'sku' => 'LI-ION-B200'
            ],
            // Robotic Sourcing
            [
                'name' => 'Servo Driver Protocol',
                'category' => 'Servo Drivers',
                'price' => 3200000,
                'stock' => 85,
                'img' => 'https://images.unsplash.com/photo-1531746790731-6c087fecd65a?auto=format&fit=crop&q=80&w=800',
                'sku' => 'SERVO-DRV-X1'
            ],
            [
                'name' => 'Actuator Arm Module M4',
                'category' => 'Actuator Arms',
                'price' => 18500000,
                'stock' => 5,
                'img' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800',
                'sku' => 'ACT-ARM-M4'
            ]
        ];

        foreach ($products as $p) {
            $subCat = Category::where('name', $p['category'])->first();
            Product::create([
                'name' => $p['name'],
                'category_id' => $subCat ? $subCat->id : 1,
                'price' => $p['price'],
                'stock' => $p['stock'],
                'stock_qty' => $p['stock'],
                'sku' => $p['sku'],
                'image_url' => $p['img'],
                'is_available' => true,
            ]);
        }
    }
}
