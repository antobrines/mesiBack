<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;

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

route::get('/user', [UserController::class, 'getUserByRequest'])->middleware('auth:api');
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::post('/register', [UserController::class, 'create']);

//Adresses
route::get('/addresses', [AddressController::class, 'index']);
route::post('/new/address', [AddressController::class, 'store']);
route::get('/address/{id}', [AddressController::class, 'show']);
route::post('/address/{id}', [AddressController::class, 'update']);
route::delete('/address/{id}', [AddressController::class, 'destroy']);
