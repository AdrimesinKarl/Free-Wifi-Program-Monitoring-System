<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationImportController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ProjectStatusController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::post('/locations/upload', [LocationImportController::class, 'upload'])->name('locations.upload');
Route::post('/locations/reset', [LocationImportController::class, 'reset'])->name('locations.reset');

Route::get('/map', [MapController::class, 'index'])->name('map');

Route::get('/project-status', [ProjectStatusController::class, 'index'])->name('project-status');

// Redirect root to dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');

});