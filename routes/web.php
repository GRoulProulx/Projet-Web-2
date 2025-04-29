<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScraperController;
use App\Http\Controllers\BottleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CellarController;
use App\Http\Controllers\CellarBottleController;

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


// Route pour gérer les bouteilles du catalogue provenant de la SAQ
Route::get('/bottles', [BottleController::class, 'index'])->name('bottle.index');
Route::get('/bottle/{bottle}', [BottleController::class, 'show'])->name('bottle.show');
Route::get('/create/bottle', [BottleController::class, 'create'])->name('bottle.create');
Route::post('/create/bottle', [BottleController::class, 'store'])->name('bottle.store');
Route::get('/edit/bottle/{bottle}', [BottleController::class, 'edit'])->name('bottle.edit');
Route::put('/edit/bottle/{bottle}', [BottleController::class, 'update'])->name('bottle.update');
Route::delete('/bottle/{bottle}', [BottleController::class, 'destroy'])->name('bottle.destroy');

// Route pour gérer les celliers
Route::get('/cellars', [CellarController::class, 'index'])->name('cellar.index');
Route::get('/cellar/{cellar}', [CellarController::class, 'show'])->name('cellar.show');
Route::get('/create/cellar', [CellarController::class, 'create'])->name('cellar.create');
Route::post('/create/cellar', [CellarController::class, 'store'])->name('cellar.store');
Route::get('/edit/cellar/{cellar}', [CellarController::class, 'edit'])->name('cellar.edit');
Route::put('/edit/cellar/{cellar}', [CellarController::class, 'update'])->name('cellar.update');
Route::delete('/cellar/{cellar}', [CellarController::class, 'destroy'])->name('cellar.destroy');

// Route pour gérer les bouteilles dans le cellier
Route::get('/cellar-bottles', [CellarBottleController::class, 'index'])->name('cellar_bottle.index');
Route::get('/cellar-bottle/{cellar-bottle}', [CellarBottleController::class, 'show'])->name('cellar_bottle.show');
Route::get('/create/cellar-bottle', [CellarBottleController::class, 'create'])->name('cellar_bottle.create');
Route::post('/create/cellar-bottle', [CellarBottleController::class, 'store'])->name('cellar_bottle.store');
Route::get('/edit/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'edit'])->name('cellar_bottle.edit');
Route::put('/edit/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'update'])->name('cellar_bottle.update');
Route::delete('/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'destroy'])->name('cellar_bottle.destroy');

// Routes pour les utilisateurs
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/register', [UserController::class, 'create'])->name('user.create');
Route::post('/register', [UserController::class, 'store'])->name('user.store');
// TODO: Le reste des routes pour l'oublie du mot de passe, la modification du mot de passe, etc.

// Routes AUTHENTIFICATION
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');

// Route pour le scraper
Route::get('/test-scraper', [ScraperController::class, 'index']);

