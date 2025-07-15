<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (session()->has('user_id')) {
        return redirect('/user-dashboard');
    }
    return view('welcome');
});


// Admin
Route::get('/admin',[AdminController::class, 'index'])->name('adminlogin');
Route::get('/admin/register',[AdminController::class, 'adminregister']);
Route::post('/admin/store',[AdminController::class, 'store'])->name('admin_register');
Route::post('/admin/login',[AdminController::class,'login'])->name('admin_login');
Route::get('/admin/logout',[AdminController::class,'logout'])->name('admin_logout');
Route::get('/admin/dashboard',[HomeController::class,'index'])->name('dashboard');

Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
Route::get('/admin/boards', [AdminController::class, 'boards'])->name('admin.boards');
Route::get('/admin/boards/{id}', [AdminController::class, 'board_details'])->name('admin.boards.details');
Route::get('/admin/payout-requests',[PaymentController::class,'payout_request'])->name('admin.payout_requests');

Route::get('/admin/products',[ProductController::class,'product_list'])->name('admin.products');
Route::get('/admin/add-product',[ProductController::class,'add_product'])->name('admin.add_product');
Route::get('/admin/edit-product/{id}',[ProductController::class,'edit_product'])->name('admin.edit.product');
Route::post('/admin/store-product',[ProductController::class,'store_product'])->name('admin.store_product');
Route::post('/admin/update-product/{id}',[ProductController::class,'update_product'])->name('admin.update_product');



Route::get('/login',[UserController::class,'user_login'])->name('login');
Route::post('/user-login',[UserController::class,'login'])->name('user_login');
Route::get('/register',[UserController::class, 'register'])->name('register');
Route::post('/store',[UserController::class, 'store'])->name('user_store');

Route::get('/user-logout',[UserController::class,'logout'])->name('user_logout');
Route::get('/user-dashboard',[HomeController::class,'user_dashboard'])->name('user_dashboard');

Route::get('/product',[ProductController::class,'index'])->name('product');
Route::get('/change-password', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
    return view('viw_change_password');
})->name('change_password');
Route::post('/user/change-password', [UserController::class, 'updatePassword'])->name('user.change_password.update');

Route::get('/user/update-profile', [UserController::class, 'showUpdateProfileForm'])->name('user.edit_profile');
Route::post('/user/update-profile', [UserController::class, 'updateProfile'])->name('user.update_profile');

Route::get('/about-us', function () {
    return view('viw_about_us');
})->name('about_us');

Route::get('/withdraw-request',[PaymentController::class,'index'])->name('withdraw_request');
Route::post('/payment-request',[PaymentController::class,'payment_request'])->name('payment_request');