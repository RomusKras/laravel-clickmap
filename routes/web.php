<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\ClickController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('sites', SiteController::class)->middleware('auth');
# Маршрут карты кликов
Route::get('/sites/{site}/click-map', [ClickController::class, 'show'])->middleware('auth')->name('sites.click-map');

Route::get('/tech-spec', [SiteController::class, 'techSpec'])->name('tech.spec');

Route::get('/sites/{site}/activity-chart', [SiteController::class, 'activityChart'])->name('activity.chart');


require __DIR__.'/auth.php';
