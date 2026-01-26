<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ========================================
        // 1. ADMIN ACCOUNT (untuk testing)
        // ========================================
        User::create([
            'name' => 'Admin GrosirKu',
            'email' => 'admin@grosirku.com',
            'password' => bcrypt('admin123'), // Password: admin123
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // ========================================
        // 2. USER ACCOUNT (untuk testing)
        // ========================================
        User::create([
            'name' => 'User Demo',
            'email' => 'user@grosirku.com',
            'password' => bcrypt('user123'), // Password: user123
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // ========================================
        // 3. SEED CATEGORIES & PRODUCTS
        // ========================================
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class, // Generate dummy orders
        ]);
    }
}
