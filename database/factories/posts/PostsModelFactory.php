<?php

namespace Database\Factories\posts;

use App\Models\posts\PostsModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostsModelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostsModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Definimos que datos faker queremos poner en cada columna
        return [
            'titulo' => $this->faker->sentence(),
            'contenido' => $this->faker->paragraph(),
        ];
    }
}
