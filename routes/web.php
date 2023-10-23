<?php

use App\Http\Controllers\checkController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SSOMigrationController;

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

Route::get('/', [SSOMigrationController::class, 'render']);
Route::post('/verify', [SSOMigrationController::class, 'verifyUser']);

//Check 
Route::get('/check', [checkController::class, 'check'])->name('check');
Route::get('/getAllGroups', [checkController::class, 'getAllGroups'])->name('getAll');
Route::get('/getAllUsers', [checkController::class, 'getAllUsers'])->name('getAll');
Route::get('/getUser', [checkController::class, 'getUser'])->name('get');
Route::get('/getGroup', [checkController::class, 'getGroup'])->name('get');
