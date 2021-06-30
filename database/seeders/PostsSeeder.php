<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\posts\PostsModel;

class PostsSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // Creamos 60 registros para la tabla post con campos de prueba
        PostsModel::factory(60)->create();
    }
}
