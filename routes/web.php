<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\auth\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\superadmin\ItemsController;
use App\Http\Controllers\superadmin\ProfileController;
use App\Http\Controllers\superadmin\AdminListController;
use App\Http\Controllers\superadmin\CustomersListController;
use App\Http\Controllers\superadmin\CustomerRequestController;

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


Route::controller(AuthController::class)->group(function(){
    Route::middleware(RedirectIfAuthenticated::class)->group(function(){
        Route::get('/', 'login_view')->name('login');
        Route::post('/', 'login');
        Route::get('register', 'register_view')->name('register');
        Route::post('register', 'register');
    });
    Route::get('logout', 'logout')->name('logout');
});

Route::middleware(Authenticate::class)->group(function(){
    Route::controller(ProfileController::class)->group(function(){
     Route::get('superadmin/profile/edit', 'edit')->name('profile');
     Route::post('superadmin/details/edit', 'update_details')->name('profile.details');
     Route::post('superadmin/picture/edit', 'update_picture')->name('profile.picture');
     Route::post('superadmin/password/edit', 'update_password')->name('profile.password');


    });
});

Route::controller(AdminListController::class)->middleware(Authenticate::class)->group(function(){
    Route::get('superadmin/adminlist/show', 'index')->name('admin.show');
    Route::get('superadmin/adminlist/create', 'create')->name('admin.create');
    Route::post('superadmin/adminlist/create', 'store');
    Route::get('superadmin/adminlist/{user}/edit', 'edit')->name('admin.edit');
    Route::post('superadmin/adminlist/{user}/edit', 'update');
    Route::get('superadmin/adminlist/{user}/destroy', 'destroy')->name('admin.destroy');
});

Route::controller(CustomersListController::class)->middleware(Authenticate::class)->group(function(){
    Route::get('superadmin/customerlist/index', 'index')->name('customerlist');
    Route::get('superadmin/customerlist/add', 'create')->name('customer.add');
    Route::post('superadmin/customerlist/add', 'store');
    Route::get('superadmin/customerlist/{customer}/details', 'details')->name('customer.details');
    Route::get('superadmin/customerlist/{customer}/edit', 'edit')->name('customer.edit');
    Route::post('superadmin/customerlist/{customer}/edit', 'update');
    Route::get('superadmin/customerlist/{customer}/destroy', 'destroy')->name('customer.destroy');
});

Route::controller(ItemsController::class)->middleware(Authenticate::class)->group(function(){
    Route::get('superadmin/item/add', 'index')->name('item.add');
});

Route::controller(CustomerRequestController::class)->middleware(Authenticate::class)->group(function(){
    Route::get('superadmin/customerrequest/index', 'index')->name('request.show');
});
