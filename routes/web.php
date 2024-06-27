<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AddAccountController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;

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
    return redirect('login');
});


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-user', [LoginController::class, 'login'])->name('user-login');
Route::get('/create', [AddAccountController::class, 'create'])->name('create');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// employee

Route::get('/employee', [EmployeeController::class, 'index'])->name('employee-dashboard')->middleware(['auth', 'role:1|2']);
Route::get('/employee/table', [EmployeeController::class, 'employeeTable'])->name('employee.table')->middleware(['auth', 'role:1|2']);
Route::get('/employee/add', [EmployeeController::class, 'add'])->name('employee.add')->middleware(['auth', 'role:1|2']);
Route::post('/employee/create', [EmployeeController::class, 'create'])->name('employee.create')->middleware(['auth', 'role:1']);
Route::get('/employee/details/{id}', [EmployeeController::class, 'show'])->name('employee.details')->middleware(['auth', 'role:1']);
Route::get('/employee/edit', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware(['auth', 'role:1']);
Route::post('/employee/edit/save', [EmployeeController::class, 'saveEdit'])->name('employee.save')->middleware(['auth', 'role:1']);


// Attemdance
Route::post('/attendance', [AttendanceController::class, 'upload'])->name('attendance-upload')->middleware(['auth', 'role:1']);
