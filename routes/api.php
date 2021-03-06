<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\VerificationController;

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

// Middleware for admin
Route::middleware(['auth:api', 'roles:admin', 'verified'])->group(function () {
	// User
	route::get('/users', [UserController::class, 'index']);

	// Role
	route::get('/roles', [RoleController::class, 'index']); // Pagination
	route::post('/new/role', [RoleController::class, 'store']);
	route::get('/role/{id}', [RoleController::class, 'show']);
	route::post('/role/{id}', [RoleController::class, 'update']);
	route::delete('/role/{id}', [RoleController::class, 'destroy']);

	// Category
	route::post('/new/category', [CategoryController::class, 'store']);
	route::post('/category/{id}', [CategoryController::class, 'update']);
	route::delete('/category/{id}', [CategoryController::class, 'destroy']);
});

// Middleware for user
Route::middleware(['auth:api', 'roles:user,admin', 'verified'])->group(function () {
	// User
	route::get('/user', [UserController::class, 'getUserByRequest']);
	route::get('/user/{id}', [UserController::class, 'show']);
	route::post('/user/{id}', [UserController::class, 'update']);
	route::delete('/user/{id}', [UserController::class, 'destroy']);

	// Adress
	route::get('/addresses', [AddressController::class, 'index']);
	route::post('/new/address', [AddressController::class, 'store']);
	route::get('/address/{id}', [AddressController::class, 'show']);
	route::post('/address/{id}', [AddressController::class, 'update']);
	route::delete('/address/{id}', [AddressController::class, 'destroy']);

	// Products
	route::post('/new/product', [ProductController::class, 'store']);
	route::post('/product/{id}', [ProductController::class, 'update']);
	route::delete('/product/{id}', [ProductController::class, 'destroy']);

	// Image
	route::get('/image', [ImageController::class, 'index']);
	route::post('/new/image', [ImageController::class, 'store']);
	route::get('/image/{id}', [ImageController::class, 'show']);
	route::delete('/image/{id}', [ImageController::class, 'destroy']);

	route::any('/userads', [UserController::class, 'getUserAds']);
});


route::post('/new/user', [UserController::class, 'store']);

route::get('/categories', [CategoryController::class, 'index']);
route::get('/category/{id}', [CategoryController::class, 'show']);
route::get('/category/{id}/products', [CategoryController::class, 'getProductByCategories']);

route::get('/products', [ProductController::class, 'index']);
route::get('/products/search/{name}', [ProductController::class, 'searchByName']);
route::get('/product/{id}', [ProductController::class, 'show']);
route::get('/product/{id}/categories', [ProductController::class, 'getCategoriesProduct']);
route::get('/product/{id}/image', [ProductController::class, 'getimagesByProduct']);
route::get('/product/{id}/image', [ProductController::class, 'getimagesByProduct']);

route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
