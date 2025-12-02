<?php

namespace Database\Seeders;

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
        // Llamar a los seeders de usuarios y productos(evitamos usar Model::unguard() para mejorar el rendimiento o el factory)
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
