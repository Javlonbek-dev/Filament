<?php

use App\Http\Controllers\PDFController;
use App\Livewire\OrderSignUpPage;
use Illuminate\Support\Facades\Route;

Route::get('/order-sign-up', OrderSignUpPage::class);

Route::get('/generate-pdf/{id}', [PDFController::class, 'generateApplicationPDF'])->name('generate-application-pdf');


