<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Llamamos a todos los seeder necesarios
        $this->call([
            PostsSeeder::class,
        ]);
    }
}
