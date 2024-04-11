<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::any('{any}', function(){
    return view('home');
});

Route::get('/home', [EmployeeController::class, 'index'])->name('home');
//functionalities
Route::post('employee/create', [EmployeeController::class, 'store']);
Route::get('employee/fetch', [EmployeeController::class, 'fetch']);
Route::put('employee/{id}', [EmployeeController::class, 'update']);
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy']);