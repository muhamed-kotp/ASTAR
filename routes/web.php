<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PartitionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

 //Middleware Group  For Super Admin Only
 Route::group(['middleware' => 'IsLoginAdmin'], function () {

// Items: Create
Route::get('/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

//Items: Edit
Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
Route::post('items/update/{id}', [ItemController::class, 'update'])->name('items.update');

//Items: Delete
Route::get('items/delete/{id}', [ItemController::class, 'delete'])->name('items.delete');

//catgory: create
Route::get('/category/create', [CategoryController::class, 'create'])->name('category.create');
Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

//catgory: Edit
Route::get('/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

//category:delete
Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

//Partition: create
Route::get('/partition/create', [PartitionController::class, 'create'])->name('partition.create');
Route::post('/partition/store', [PartitionController::class, 'store'])->name('partition.store');

//Partition: Edit
Route::get('/partition/edit/{id}', [PartitionController::class, 'edit'])->name('partition.edit');
Route::post('/partition/update/{id}', [PartitionController::class, 'update'])->name('partition.update');

//Partition:delete
Route::get('/partition/delete/{id}', [PartitionController::class, 'delete'])->name('partition.delete');

// Orders
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');

// users Read
Route::get('/users', [AuthController::class, 'index'])->name('users.index');
//users: Make admin
Route::get('/users/edit/{id}', [AuthController::class, 'edit'])->name('users.edit');

 }) ;

 //Middleware Group  For Login Users Only

 Route::group(['middleware' => 'IsLogin'], function () {
//Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

//checkOut

Route::get('/check-out', [OrderController::class, 'checkOut'])->name('checkOut');
Route::post('/handle-check-out', [OrderController::class, 'handleCheckOut'])->name('handle.checkOut');

 });

//Welcome
Route::get('/', [CategoryController::class, 'welcome'])->name('welcome');
// Items: read
Route::get('/items/show/{id}', [ItemController::class, 'show'])->name('items.show');

//Category: read
Route::get('/category/show/{id}', [CategoryController::class, 'show'])->name('category.show');

//Partition: read
Route::get('/partition/show/{id}', [PartitionController::class, 'show'])->name('partition.show');

//registration
Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/handle-register', [AuthController::class, 'handleRegister'])->name('auth.handleRegister');

//Login
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/handle-login', [AuthController::class, 'handleLogin'])->name('auth.handleLogin');




//cart

Route::get('/shopping-cart', [CartController::class, 'itemCart'])->name('shopping.cart');
Route::get('/item/{id}', [CartController::class, 'addItemtoCart'])->name('add.to.cart');
Route::get('/plus-quantity/{id}', [CartController::class, 'plusQuantity'])->name('plus.quantity');
Route::get('/minus-quantity/{id}', [CartController::class, 'minusQuantity'])->name('minus.quantity');
Route::get('/cart-delete/{id}', [CartController::class, 'delete'])->name('delete.cart.product');