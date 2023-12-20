<?php

use App\Http\Controllers\Api\Admin\RolesAndPermissionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Item\ItemController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Category\CategoryController;
use App\Http\Controllers\Api\Partition\PartitionController;



Route::middleware(['auth:sanctum'])->group( function () {

    // Items: Create
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    //Items: Edit
    Route::post('items/update/{id}', [ItemController::class, 'update'])->name('items.update');

    //Items: Delete
    Route::get('items/delete/{id}', [ItemController::class, 'delete'])->name('items.delete');

    //catgory: create
    Route::post('/category/store', [CategoryController::class, 'store'])->name('category.store');

    //catgory: Edit
    Route::post('/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

    //category:delete
    Route::get('/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    //Partition: create
    Route::post('/partition/store', [PartitionController::class, 'store'])->name('partition.store');

    //Partition: Edit
    Route::post('/partition/update/{id}', [PartitionController::class, 'update'])->name('partition.update');

    //Partition:delete
    Route::get('/partition/delete/{id}', [PartitionController::class, 'delete'])->name('partition.delete');

    // Orders
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');

    //users
    Route::get('/users', [AuthController::class, 'index'])->name('users.index');

    //users: Change Role
    Route::post('/users/update/{id}', [AuthController::class, 'update'])->name('users.update');


});

Route::group(['middleware' => ["auth:sanctum"]], function () {

    //Profile
    Route::get('/profile', function (Request $request) {
        return $request->user();
    })->name('profile');

    //Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    //checkOut
    Route::post('/handle-check-out',  [OrderController::class, 'store'])->name('handle.checkOut');

});

Route::group(['middleware' => "auth:sanctum" , 'prefix' =>'admin'], function () {
    Route::resource('role-permission',RolesAndPermissionsController::class);
});


//Registeration
Route::post('/handleRegister',[AuthController::class,'handleRegister']);
//Login
Route::post('/handleLogin',[AuthController::class,'handleLogin']);



////Categories and Patitions
Route::get('/', [CategoryController::class, 'index'])->name('welcome');

//Category: Show
Route::get('/category/show/{id}', [CategoryController::class, 'show'])->name('category.show');

//Partition: show
Route::get('/partition/show/{id}', [PartitionController::class, 'show'])->name('partition.show');

// Items: show
Route::get('/items', [ItemController::class, 'index'])->name('items.index');
Route::get('/items/show/{id}', [ItemController::class, 'show'])->name('items.show');