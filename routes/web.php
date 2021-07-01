<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\posts\PostsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Rutas para conectarse con la parte del backend.
Route::prefix('s')->group(function () {
    
    // Posts
    Route::get('posts', [PostsController::class, 'index']);
    Route::post('posts', [PostsController::class, 'store']);
    Route::post('posts/{id}', [PostsController::class, 'update']);
    Route::post('posts/delete/{id}', [PostsController::class, 'delete']);
});

// Las rutas publicas que accede el cliente se van a manejar mediante vue, ya que gracias a esto evitamos que la pagina web haga un reload completo cada vez que quiera acceder a un nuevo lugar.
Route::get('/{any}', function(){
    return view('vue/renderVue');
})->where('any', '.*');
