<?php

use App\Http\Controllers\GridController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesAndPermissionsController;
use App\Http\Controllers\SiteRestrictedController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/restricted', [SiteRestrictedController::class, 'index'])->name('restricted.index');
Route::post('/restricted', [SiteRestrictedController::class, 'verifyPassword'])->name('restricted.post');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/roles-and-permissions', [RolesAndPermissionsController::class, 'index'])->name('roles-and-permissions');

    //grids
    Route::get('/grids', [GridController::class, 'index'])->name('grids');
    Route::get('/grids/create', [GridController::class, 'create'])->name('grids.create');
    Route::post('/grids/create', [GridController::class, 'store'])->name('grids.store');
});

Route::get('/get-permissions', function () {
    return auth()->check() ? auth()->user()->jsPermissions() : 0;
});

require __DIR__ . '/auth.php';
