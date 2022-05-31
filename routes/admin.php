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

    Route::get('logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
    // -- users
    Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
    Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'setCarrier'])->name('set_carrier');
    // -- invoices
    Route::get('invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{id}', [\App\Http\Controllers\Admin\InvoiceController::class, 'createInvoicePdf'])->name('invoices.show');
    // ---  reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/createList', [\App\Http\Controllers\Admin\ReportController::class, 'createReportsList'])->name('reports.createList');
    Route::get('reports/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'createReportPdf'])->name('reports.show');

    Route::get('logs', [\App\Http\Controllers\Admin\IndexController::class, 'readLogs'])->name('logs');
});



