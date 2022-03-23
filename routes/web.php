<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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

// ---- create users from download file
Route::get('/users/create', [\App\Http\Controllers\UserController::class, 'createUsers']);
// ---- create reports from download file
Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'createReports']);
// ---- create invoices from download file
Route::get('invoices/create', [\App\Http\Controllers\InvoiceController::class, 'createInvoices']);



Route::middleware(['auth:web', 'verifiedEmail'])->group(function (){

    Route::get('home', [\App\Http\Controllers\IndexController::class, 'index'])->name('home');
    Route::get('users/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::patch('users/edit', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::post('users/changeEmail', [\App\Http\Controllers\UserController::class, 'changeEmail'])->name('changeEmail');
    Route::post('users/changePassword', [\App\Http\Controllers\UserController::class, 'changePassword'])->name('changePassword');
    // ---  reports
    Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/createList', [\App\Http\Controllers\ReportController::class, 'createReportsList'])->name('reports.createList');
    Route::get('reports/{id}', [\App\Http\Controllers\ReportController::class, 'createReportPdf'])->name('reports.show');
    // --- invoices
    Route::get('invoices', [\App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('invoices/{id}', [\App\Http\Controllers\InvoiceController::class, 'createInvoicePdf'])->name('invoices.show');
    // --- places
    Route::get('places', [\App\Http\Controllers\PlaceController::class, 'index'])->name('places.index');

//    Route::any('/logout', [AuthenticatedSessionController::class, 'destroy'])
//        ->name('logout');
});



