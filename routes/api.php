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

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::put('/user/update', [UserController::class, 'update']);
Route::post('/user/upload', [UserController::class, 'upload'])->middleware(ApiAuthMiddleware::class);
Route::get('/user/avatar/{filename}', [UserController::class, 'getImage']);
Route::get('/user/detail/{id}', [UserController::class, 'detail']);

Route::post('/categoria', [CategoriaController::class, 'create'])->middleware(ApiAuthMiddleware::class);
Route::get('/categorias', [CategoriaController::class, 'list'])->middleware(ApiAuthMiddleware::class);
Route::put('/categoria/{id}', [CategoriaController::class, 'update'])->middleware(ApiAuthMiddleware::class);
Route::delete('/categoria/{id}', [CategoriaController::class, 'delete'])->middleware(ApiAuthMiddleware::class);
Route::get('/categoria-find/{id}', [CategoriaController::class, 'find'])->middleware(ApiAuthMiddleware::class);
Route::put('/categoria-search', [CategoriaController::class, 'search'])->middleware(ApiAuthMiddleware::class);

Route::post('/marca', [MarcaController::class, 'create'])->middleware(ApiAuthMiddleware::class);
Route::get('/marcas', [MarcaController::class, 'list'])->middleware(ApiAuthMiddleware::class);
Route::put('/marca/{id}', [MarcaController::class, 'update'])->middleware(ApiAuthMiddleware::class);
Route::delete('/marca/{id}', [MarcaController::class, 'delete'])->middleware(ApiAuthMiddleware::class);
Route::get('/marca-find/{id}', [MarcaController::class, 'find'])->middleware(ApiAuthMiddleware::class);
Route::put('/marca-search', [MarcaController::class, 'search'])->middleware(ApiAuthMiddleware::class);

Route::post('/distribuidor', [DistribuidorController::class, 'create'])->middleware(ApiAuthMiddleware::class);
Route::get('/distribuidores', [DistribuidorController::class, 'list'])->middleware(ApiAuthMiddleware::class);
Route::put('/distribuidor/{id}', [DistribuidorController::class, 'update'])->middleware(ApiAuthMiddleware::class);
Route::delete('/distribuidor/{id}', [DistribuidorController::class, 'delete'])->middleware(ApiAuthMiddleware::class);
Route::get('/distribuidor-find/{id}', [DistribuidorController::class, 'find'])->middleware(ApiAuthMiddleware::class);
Route::put('/distribuidor-search', [DistribuidorController::class, 'search'])->middleware(ApiAuthMiddleware::class);

Route::post('/producto', [ProductoController::class, 'create'])->middleware(ApiAuthMiddleware::class);
Route::get('/productos', [ProductoController::class, 'list'])->middleware(ApiAuthMiddleware::class);
Route::put('/producto/{id}', [ProductoController::class, 'update'])->middleware(ApiAuthMiddleware::class);
Route::delete('/producto/{id}', [ProductoController::class, 'delete'])->middleware(ApiAuthMiddleware::class);
Route::get('/producto-find/{id}', [ProductoController::class, 'find'])->middleware(ApiAuthMiddleware::class);
Route::put('/producto-search', [ProductoController::class, 'search'])->middleware(ApiAuthMiddleware::class);
Route::post('/producto/upload', [ProductoController::class, 'upload'])->middleware(ApiAuthMiddleware::class);
Route::get('/producto/{filename}', [ProductoController::class, 'getImage'])->middleware(ApiAuthMiddleware::class);
