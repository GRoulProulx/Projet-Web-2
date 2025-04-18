<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;


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
// Routes UTILISATEURS
// TODO: Le reste des routes pour l'oublie du mot de passe, la modification du mot de passe, etc.


// ROUTES POUR GÉRER LES BOUTEILLES
Route::get('/bottles', [BottleController::class, 'index'])->name('bottle.index');
Route::get('/bottle/{bottle}', [BottleController::class, 'show'])->name('bottle.show');
Route::get('/create/bottle', [BottleController::class, 'create'])->name('bottle.create');
Route::post('/create/bottle', [BottleController::class, 'store'])->name('bottle.store');
Route::get('/edit/bottle/{bottle}', [BottleController::class, 'edit'])->name('bottle.edit');
Route::put('/edit/bottle/{bottle}', [BottleController::class, 'update'])->name('bottle.update');
Route::delete('/bottle/{bottle}', [BottleController::class, 'destroy'])->name('bottle.destroy');

// Routes pour les utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Routes AUTHENTIFICATION
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');

// Route pour le scraper
Route::get('/test-scraper', [ScraperController::class, 'test']);

