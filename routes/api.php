<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt.auth')->group(function () {
    route::post('update/name', [UserController::class, 'updateName']);
    route::post('update/image', [UserController::class, 'updateImage']);
    route::post('update/password', [UserController::class, 'changePassword']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logOut'])->middleware('jwt.auth');
Route::post('register', [AuthController::class, 'register']);
Route::post('verify/code', [AuthController::class, 'verifyCode']);
Route::post('send/code', [AuthController::class, 'sendCode']);
Route::get('all/street', [CategoryController::class , 'index']);
Route::get('street/market/{id}', [CategoryController::class , 'allCompaniesinStreet']);
Route::get('categories/market/{id}', [CategoryController::class , 'allCategoriesInCompanies']);
Route::get('brands/category/{id}', [CategoryController::class , 'allBrandInCategories']);
Route::get('products/brand/{id}', [CategoryController::class , 'allProductsInBrand']);
Route::get('product/{id}', [CategoryController::class , 'productDetails']);