<?php

namespace App\Http\Controllers\posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\posts\PostsModel;
use Exception;

class PostsController extends Controller{
    
    /**
     * Metodo para obtener los posts
     * @return \Illuminate\Http\JsonResponse
     * @return $posts
     */
    public function index(){
        // Obtenemos todos los post con una paginacion de 20 items por pagina
        $posts = PostsModel::paginate(20);

        return response()->json([
            'data' => $posts->items(),
            'current_page' => $posts->currentPage(),
            'page_count' => $posts->lastPage(),
            'has_next_page' => $posts->hasMorePages(),
            'total' => $posts->total(),
            'per_page' => $posts->perPage(),
        ]);
    }

    /**
     * Metodo para crear un nuevo post
     * @param Request $request (titulo, contenido)
     * @return \Illuminate\Http\JsonResponse
     * @return $post
     */
    public function store(Request $request){
        $data = $request->all();

        // Validamos la informacion que llega en request
        $validator = PostsModel::validator($data);
        if($validator->fails()){
            abort(response($validator->errors(), 400));
        }

        // Generamos una nueva instancia de PostsModel
        $post = new PostsModel($data);
        try {
            // Guardamos el post nuevo
            $post->save();
        } catch (Exception $err) {
            // En caso de error abortamos y devolvemos el error
            abort(response($err, 500));
        }

        // Retornamos el post que se creo
        return response()->json($post);
    }

    public function update(Request $request, $id){
        $data = $request->all();

        // Validamos la informacion que llega en request
        $validator = PostsModel::validator($data);
        if($validator->fails()){
            abort(response($validator->errors(), 400));
        }

        try {
            // Buscamos el id que nos pasan y actualizamos la info de dicho post
            $post_edit = PostsModel::findOrFail($id);
            $post_edit->fill($data);
        } catch (Exception $err) {
            // En caso de error abortamos y devolvemos el error
            abort(response($err, 500));
        }

        // Retornamos el post editado
        return response()->json($post_edit);
    }

}
