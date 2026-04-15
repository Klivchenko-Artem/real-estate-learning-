<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\CatalogController;
use App\Http\Controllers\Client\FeedbackController;
use App\Http\Controllers\Client\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* Auth */
Auth::routes(['verify' => false, 'reset' => false, 'confirm' => false, 'register' => false]);

/* Admin */
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [AdminFeedbackController::class, 'index'])->name('feedback.index');

    Route::resource('properties', AdminPropertyController::class)->except('show');
    Route::get('properties.table', [AdminPropertyController::class, 'datatable'])->name('properties.table');

    Route::resource('categories', CategoryController::class)->except('show');
    Route::get('categories.table', [CategoryController::class, 'datatable'])->name('categories.table');

    Route::get('feedbacks.table', [AdminFeedbackController::class, 'datatable'])->name('feedbacks.table');

    Route::resource('users', UserController::class)->only(['edit', 'update']);

    Route::resource('seo', SeoController::class)->except('show');
    Route::get('seo.table', [SeoController::class, 'datatable'])->name('seo.table');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('robots.txt', [SeoController::class, 'robotsEdit'])->name('robots.edit');
    Route::post('robots.txt', [SeoController::class, 'robotsSave'])->name('robots.save');
});

/* Client */
Route::get('/', HomeController::class)->name('client.home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('client.catalog');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('client.feedback');

/* SEO */
Route::get('robots.txt', [SeoController::class, 'robots']);
Route::get('sitemap.xml', [SeoController::class, 'sitemap']);
