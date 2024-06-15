<?php

use App\Http\Controllers\AddAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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
    return redirect('/login');
});


Route::get('/login', [LoginController::class, 'index']);
Route::post('/login-user', [LoginController::class, 'login'])->name('user-login');
Route::get('/create', [AddAccountController::class, 'create'])->name('create');

// employee
Route::get('/employee', [AddAccountController::class, 'employee'])->name('employee');
