<?php

use Illuminate\Support\Facades\Route;

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

// Las rutas publicas que accede el cliente se van a manejar mediante vue, ya que gracias a esto evitamos que la pagina web haga un reload completo cada vez que quiera acceder a un nuevo lugar.
Route::get('/{any}', function(){
    return view('vue/renderVue');
})->where('any', '.*');
