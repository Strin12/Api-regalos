<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\DistribuidorController;
use App\Http\Controllers\ProductoController;
use App\Http\Middleware\ApiAuthMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/login', [UserController::class, 'login']);
//Route::post('/register', [UserController::class, 'register']);
Route::put('/user/update', [UserController::class, 'update']);
Route::post('/user/upload', [UserController::class, 'upload']);
Route::get('/user/avatar/{filename}', [UserController::class, 'getImage']);
Route::get('/user/detail/{id}', [UserController::class, 'detail']);

Route::post('/categoria', [CategoriaController::class, 'create']);
Route::get('/categorias', [CategoriaController::class, 'list']);
Route::put('/categoria/{id}', [CategoriaController::class, 'update']);
Route::delete('/categoria/{id}', [CategoriaController::class, 'delete']);
Route::get('/categoria-find/{id}', [CategoriaController::class, 'find']);
Route::put('/categoria-search', [CategoriaController::class, 'search']);

Route::post('/marca', [MarcaController::class, 'create']);
Route::get('/marcas', [MarcaController::class, 'list']);
Route::put('/marca/{id}', [MarcaController::class, 'update']);
Route::delete('/marca/{id}', [MarcaController::class, 'delete']);
Route::get('/marca-find/{id}', [MarcaController::class, 'find']);
Route::put('/marca-search', [MarcaController::class, 'search']);

Route::post('/distribuidor', [DistribuidorController::class, 'create']);
Route::get('/distribuidores', [DistribuidorController::class, 'list']);
Route::put('/distribuidor/{id}', [DistribuidorController::class, 'update']);
Route::delete('/distribuidor/{id}', [DistribuidorController::class, 'delete']);
Route::get('/distribuidor-find/{id}', [DistribuidorController::class, 'find']);
Route::put('/distribuidor-search', [DistribuidorController::class, 'search']);

Route::post('/producto', [ProductoController::class, 'create']);
Route::get('/productos', [ProductoController::class, 'list']);
Route::put('/producto/{id}', [ProductoController::class, 'update']);
Route::delete('/producto/{id}', [ProductoController::class, 'delete']);
Route::get('/producto-find/{id}', [ProductoController::class, 'find']);
Route::put('/producto-search', [ProductoController::class, 'search']);
Route::post('/producto/upload', [ProductoController::class, 'upload']);
Route::get('/producto/{filename}', [ProductoController::class, 'getImage']);
