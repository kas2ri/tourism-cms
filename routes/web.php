<?php

use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DestinationController;
use App\Http\Controllers\Admin\InquiryController as AdminInquiryController;
use App\Http\Controllers\Admin\InsiderController;
use App\Http\Controllers\Admin\PackageController as AdminPackageController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\LeadCaptureController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/api/packages/{id}/itinerary', [PackageController::class, 'itineraryData'])->name('api.packages.itinerary');
Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
Route::post('/guide-download', [LeadCaptureController::class, 'store'])->name('guide.download');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuth::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuth::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuth::class, 'logout'])->name('admin.logout');

    // Authenticated Admin Dashboard & CMS Management
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.root');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // CSV export must precede resource routes to prevent conflict
        Route::get('/inquiries/export', [AdminInquiryController::class, 'exportCsv'])->name('admin.inquiries.export');

        // Resources
        Route::resource('packages', AdminPackageController::class, ['as' => 'admin']);
        Route::resource('destinations', DestinationController::class, ['as' => 'admin']);
        Route::resource('insiders', InsiderController::class, ['as' => 'admin']);
        Route::resource('reviews', ReviewController::class, ['as' => 'admin']);
        Route::post('/reviews/{review}/toggle-featured', [ReviewController::class, 'toggleFeatured'])->name('admin.reviews.toggle-featured');
        Route::resource('inquiries', AdminInquiryController::class, ['as' => 'admin'])->only(['index', 'show', 'update', 'destroy']);

        // Site Settings
        Route::get('/settings', [SettingController::class, 'edit'])->name('admin.settings.edit');
        Route::match(['put', 'post'], '/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    });
});
