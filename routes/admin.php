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
    // -- invoices
    Route::get('invoices', [\App\Http\Controllers\Admin\InvoiceController::class, 'index'])->name('invoices.index');
    //Route::post('invoices/send', [\App\Http\Controllers\Admin\InvoiceController::class, 'sendInvoiceToPartner'])->name('invoices.send');
    Route::get('invoices/{id}', [\App\Http\Controllers\Admin\InvoiceController::class, 'createInvoicePdf'])->name('invoices.show');
    Route::post('/', [\App\Http\Controllers\Admin\IndexController::class, 'setCarrier'])->name('set_carrier');

    // ---  reports
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/createList', [\App\Http\Controllers\Admin\ReportController::class, 'createReportsList'])->name('reports.createList');
    Route::get('reports/{id}', [\App\Http\Controllers\Admin\ReportController::class, 'createReportPdf'])->name('reports.show');

});



