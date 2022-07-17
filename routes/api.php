<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

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
    Route::post('logout', [AuthController::class, 'logOut']);
    route::post('update/name', [UserController::class, 'updateName']);
    route::post('update/image', [UserController::class, 'updateImage']);
    route::post('update/password', [UserController::class, 'changePassword']);
    route::post('add/address', [UserController::class, 'addAddress']);
    Route::get('all/cart', [CartController::class , 'getCart']);
    Route::post('add/cart', [CartController::class , 'addToCart']);
    Route::post('remove/cart', [CartController::class , 'removeProductInCart']);
    Route::post('remove/item/cart', [CartController::class , 'removeItemInCart']);
    Route::get('company/cart', [CartController::class , 'companiesInCart']);
    Route::get('product/company/cart/{id}', [CartController::class , 'productsCompanyInCart']);
    Route::post('create/order', [OrderController::class , 'createOrder']);
});
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('verify/code', [AuthController::class, 'verifyCode']);
Route::post('send/code', [AuthController::class, 'sendCode']);
Route::get('all/street', [CategoryController::class , 'index']);
Route::get('street/market/{id}', [CompanyController::class , 'allCompaniesinStreet']);
Route::get('categories/market/{id}', [CategoryController::class , 'allCategoriesInCompanies']);
Route::get('brands/category/{id}', [BrandController::class , 'allBrandInCategories']);
Route::get('products/brand/{id}', [ProductController::class , 'allProductsInBrand']);
Route::get('product/{id}', [ProductController::class , 'productDetails']);
Route::get('company/product/{id}', [ProductController::class , 'allProductsInCompany']);