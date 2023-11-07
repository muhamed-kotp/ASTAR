<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartitionController;
use Illuminate\Support\Facades\Route;

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

    //Welcome
    Route::get('/',[ CategoryController::class, 'welcome' ])->name('welcome');
// Items: read
    // Route::get('/books/search',[ ItemController::class, 'search' ])->name('books.search') ;
    Route::get('/items/show/{id}',[ ItemController::class, 'show' ])->name('items.show') ;

    // Items: Create
    Route::get('/items/create',[ ItemController::class, 'create' ])->name('items.create');
    Route::post('/items/store',[ ItemController::class, 'store' ])->name('items.store');

    //Items: Edit
    Route::get('/items/edit/{id}'     ,[ ItemController::class, 'edit' ])->name('items.edit');
    Route::post('items/update/{id}',[ItemController::class, 'update'])->name('items.update');

    //Items: Delete
    Route::get('items/delete/{id}',[ItemController::class,'delete'])->name('items.delete');

//Categories

//Category: read
Route::get('/category',[ CategoryController::class, 'index' ])->name('category.index') ;
Route::get('/category/show/{id}',[CategoryController::class,'show'])->name('category.show');

//catgory: create
Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');
Route::post('/category/store',[CategoryController::class,'store'])->name('category.store');

//catgory: Edit
Route::get('/category/edit/{id}',[CategoryController::class,'edit'])-> name('category.edit');
Route::post('/category/update/{id}',[CategoryController::class,'update'])-> name('category.update');

//category:delete
Route::get('/category/delete/{id}',[CategoryController::class,'delete'])->name('category.delete');

//Partitions

//Partition: read
Route::get('/partition',[ PartitionController::class, 'index' ])->name('partition.index') ;
Route::get('/partition/show/{id}',[PartitionController::class,'show'])->name('partition.show');

//Partition: create
Route::get('/partition/create',[PartitionController::class,'create'])->name('partition.create');
Route::post('/partition/store',[PartitionController::class,'store'])->name('partition.store');

//Partition: Edit
Route::get('/partition/edit/{id}',[PartitionController::class,'edit'])-> name('partition.edit');
Route::post('/partition/update/{id}',[PartitionController::class,'update'])-> name('partition.update');

//Partition:delete
Route::get('/partition/delete/{id}',[PartitionController::class,'delete'])->name('partition.delete');



//registration
Route::get('/register', [AuthController::class,'register'])-> name('auth.register');
Route::post('/handle-register', [AuthController::class,'handleRegister'])-> name('auth.handleRegister');


//Login
Route::get('/login', [AuthController::class,'login'])-> name('auth.login');
Route::post('/handle-login', [AuthController::class,'handleLogin'])-> name('auth.handleLogin');

//Logout
Route::get('/logout', [AuthController::class,'logout'])-> name('auth.logout');



//Login With GitHub
Route::get('/login/github',[AuthController::class,'redirectToProvider'])->name('auth.github.redirect');
Route::get('/login/github/callback',[AuthController::class,'handleProviderCallback'])->name('auth.github.callback');