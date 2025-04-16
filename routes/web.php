<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\BottleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ROUTES POUR GÉRER LES BOUTEILLES
Route::get('/bottles', [BottleController::class, 'index'])->name('bottle.index');
Route::get('/bottle/{bottle}', [BottleController::class, 'show'])->name('bottle.show');
Route::get('/create/bottle', [BottleController::class, 'create'])->name('bottle.create');
Route::post('/create/bottle', [BottleController::class, 'store'])->name('bottle.store');
Route::get('/edit/bottle/{bottle}', [BottleController::class, 'edit'])->name('bottle.edit');
Route::put('/edit/bottle/{bottle}', [BottleController::class, 'update'])->name('bottle.update');
Route::delete('/bottle/{bottle}', [BottleController::class, 'destroy'])->name('bottle.destroy');

// ROUTES POUR GÉRER LE SCRAPING
Route::get('/test-scraper', [ScraperController::class, 'test']);

