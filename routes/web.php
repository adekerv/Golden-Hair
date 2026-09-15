<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformationController;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::withoutMiddleware([StartSession::class, ShareErrorsFromSession::class, PreventRequestForgery::class])->group(function (): void {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/mentions-legales', [InformationController::class, 'legal'])->name('legal');
    Route::get('/confidentialite', [InformationController::class, 'privacy'])->name('privacy');
});
