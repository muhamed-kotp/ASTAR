<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiAuthController;
use App\Http\Controllers\Api\ApiItemController;
use App\Http\Controllers\Api\ApiOrderController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiPartitionController;



Route::group(['middleware' => 'IsApiAdmin'], function () {

    // Items: Create
    Route::post('/items/store', [ApiItemController::class, 'store'])->name('items.store');

    //Items: Edit
    Route::post('items/update/{id}', [ApiItemController::class, 'update'])->name('items.update');

    //Items: Delete
    Route::get('items/delete/{id}', [ApiItemController::class, 'delete'])->name('items.delete');

    //catgory: create
    Route::post('/category/store', [ApiCategoryController::class, 'store'])->name('category.store');

    //catgory: Edit
    Route::post('/category/update/{id}', [ApiCategoryController::class, 'update'])->name('category.update');

    //category:delete
    Route::get('/category/delete/{id}', [ApiCategoryController::class, 'delete'])->name('category.delete');

    //Partition: create
    Route::post('/partition/store', [ApiPartitionController::class, 'store'])->name('partition.store');

    //Partition: Edit
    Route::post('/partition/update/{id}', [ApiPartitionController::class, 'update'])->name('partition.update');

    //Partition:delete
    Route::get('/partition/delete/{id}', [ApiPartitionController::class, 'delete'])->name('partition.delete');

    // Orders
    Route::get('/order', [ApiOrderController::class, 'index'])->name('order.index');
    Route::get('/order/show/{id}', [ApiOrderController::class, 'show'])->name('order.show');

    //users
    Route::get('/users', [ApiAuthController::class, 'index'])->name('users.index');
    //users: Make admin
    Route::get('/users/edit/{id}', [ApiAuthController::class, 'edit'])->name('users.edit');


});


Route::group(['middleware' => 'IsApiUser'], function () {
    //Logout
    Route::post('/logout',[ApiAuthController::class,'logout']);

    //checkOut
    Route::post('/handle-check-out', [ApiOrderController::class, 'handleCheckOut'])->name('handle.checkOut');

});



//Registeration
Route::post('/handleRegister',[ApiAuthController::class,'handleRegister']);
//Login
Route::post('/handleLogin',[ApiAuthController::class,'handleLogin']);



////Categories and Patitions
Route::get('/', [ApiCategoryController::class, 'index'])->name('welcome');

//Category: Show
Route::get('/category/show/{id}', [ApiCategoryController::class, 'show'])->name('category.show');

//Partition: show
Route::get('/partition/show/{id}', [ApiPartitionController::class, 'show'])->name('partition.show');

// Items: show
Route::get('/items', [ApiItemController::class, 'index'])->name('items.index');
Route::get('/items/show/{id}', [ApiItemController::class, 'show'])->name('items.show');