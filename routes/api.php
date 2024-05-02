<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\NoticiaController;
use App\Http\Controllers\Api\V1\CategoriaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'prefix' => 'categoria',
], function() {
        Route::get('listado', [CategoriaController::class, 'listado']);
});
Route::group([
    'prefix' => 'noticia',
], function() {
        Route::get('listnoticia', [NoticiaController::class, 'listado']);
        Route::post('registrar', [NoticiaController::class, 'Register']);
        Route::delete('eliminar/{idnoticia}', [NoticiaController::class, 'eliminar']);

});
