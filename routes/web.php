<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'printPdf'])
    ->name('invoices.print');

Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])
    ->name('invoices.download');
    
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
