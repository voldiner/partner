<?php

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
})->name('welcome');

Route::get('home', [\App\Http\Controllers\IndexController::class, 'index'])
    ->middleware('auth:web')
    ->name('home');

Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'createUsers']);
// todo тільки зареєстрований користувач з таким id middleware створити
Route::get('users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
Route::patch('users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');