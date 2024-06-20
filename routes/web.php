<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AddAccountController;
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


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-user', [LoginController::class, 'login'])->name('user-login');
Route::get('/create', [AddAccountController::class, 'create'])->name('create');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
// employee
Route::get('/employee', [EmployeeController::class, 'index'])->name('employee-dashboard')->middleware(['auth', 'role:1|2']);
Route::get('/employee/add', [EmployeeController::class, 'add'])->name('employee.add')->middleware(['auth', 'role:1|2']);
Route::post('/employee/create', [EmployeeController::class, 'create'])->name('employee.create')->middleware(['auth', 'role:1|2']);
