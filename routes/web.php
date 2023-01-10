<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Auth\AdminController as AdminAuth;
use App\Http\Controllers\Auth\ClientController as ClientAuth;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/***
 * admin area
 */
Route::group(['prefix'=>'dashboard', 'as'=>'admin.'],function (){
    Route::group(['middleware'=> ['guest:admin']],function (){
        Route::get('/login',[AdminAuth::class,'loginForm'])->name('login.form');
        Route::post('/login',[AdminAuth::class,'login'])->name('login');
    });
    Route::group(['middleware'=> ['auth:admin']],function (){
        Route::post('/logout',[AdminAuth::class,'logout'])->name('logout');
        Route::get('/' ,[DashboardController::class, 'index'])->name('dashboard');
        Route::get('/clients/datatable' ,[ClientController::class, 'datatable'])->name('clients.datatable');
        Route::patch('/clients/toggle_status/{client}' ,[ClientController::class, 'toggle'])->name('clients.toggle_status');
        Route::resource('/clients' ,ClientController::class)->except(['show']);
        Route::get('/users/datatable' ,[AdminController::class, 'datatable'])->name('users.datatable');
        Route::resource('/users' , AdminController::class)->except(['show']);
    });

});
/**
 * clients area
 */

Route::group(['as'=>'client.'],function (){
    Route::group(['middleware'=> ['guest:client']],function (){
        Route::get('/login',[ClientAuth::class,'loginForm'])->name('login.form');
        Route::post('/login',[ClientAuth::class,'login'])->name('login');
        Route::get('/register',[ClientAuth::class,'registerForm'])->name('register.form');
        Route::post('/register',[ClientAuth::class,'register'])->name('register');
    });
    Route::group(['middleware'=> ['auth:client']],function (){
        Route::get('/welcome', function () {dd(auth('client')->user());})->middleware(['verified-email']);
        Route::get('/logout',[ClientAuth::class,'logout'])->name('logout');
        Route::get('/verify',[ClientAuth::class,'verify'])->name('verify.email');
        Route::post('/verify',[ClientAuth::class,'try_verify'])->name('try_verify');
        Route::post('/verify/resend',[ClientAuth::class,'resend_otp'])->name('verify.resend');
    });
});
