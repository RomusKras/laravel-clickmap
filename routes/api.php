<?php
use App\Http\Controllers\ClickController;

Route::post('/track-click', [ClickController::class, 'store']);
