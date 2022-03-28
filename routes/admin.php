<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes by administrators
|--------------------------------------------------------------------------
|
|
*/
Route::middleware('guest:admin')->group(function (){
    Route::get('login', [\App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login_process');

});

Route::middleware('auth:admin')->group(function (){
    Route::get('/', [\App\Http\Controllers\Admin\IndexController::class, 'index'])->name('index');
    Route::get('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');

});



