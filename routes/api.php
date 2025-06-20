<?php
use App\Http\Controllers\ClickController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api'])->group(function () {
    // Здесь ваш типовой маршрут:
    Route::post('/track-click', [ClickController::class, 'store']);
});
