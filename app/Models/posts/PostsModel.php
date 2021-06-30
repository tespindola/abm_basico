<?php

namespace App\Models\posts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validator;

class PostsModel extends Model{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['titulo', 'contenido'];

    // Valida los datos que queremos crear/editar
    public static function validator($input)
    {
        $rules = [
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
        ];

        $validator = Validator::make($input, $rules);

        return $validator;
    }
}
