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
    return view('Auth.create');
});


// Route pour gérer les bouteilles du catalogue provenant de la SAQ
Route::get('/bottles', [BottleController::class, 'index'])->name('bottle.index');
Route::get('/bottle/{bottle}', [BottleController::class, 'show'])->name('bottle.show');
Route::get('/create/bottle', [BottleController::class, 'create'])->name('bottle.create')->middleware('auth');
Route::post('/create/bottle', [BottleController::class, 'store'])->name('bottle.store')->middleware('auth');
Route::get('/edit/bottle/{bottle}', [BottleController::class, 'edit'])->name('bottle.edit')->middleware('auth');
Route::put('/edit/bottle/{bottle}', [BottleController::class, 'update'])->name('bottle.update')->middleware('auth');
Route::delete('/bottle/{bottle}', [BottleController::class, 'destroy'])->name('bottle.destroy');

// Route pour gérer les celliers
Route::get('/cellars', [CellarController::class, 'index'])->name('cellar.index')->middleware('auth');
Route::get('/cellar/{cellar}', [CellarController::class, 'show'])->name('cellar.show')->middleware('auth');
Route::get('/create/cellar', [CellarController::class, 'create'])->name('cellar.create')->middleware('auth');
Route::post('/create/cellar', [CellarController::class, 'store'])->name('cellar.store')->middleware('auth');
Route::get('/edit/cellar/{cellar}', [CellarController::class, 'edit'])->name('cellar.edit')->middleware('auth');
Route::put('/edit/cellar/{cellar}', [CellarController::class, 'update'])->name('cellar.update')->middleware('auth');
Route::delete('/cellar/{cellar}', [CellarController::class, 'destroy'])->name('cellar.destroy')->middleware('auth');

// Route pour gérer les bouteilles dans le cellier
Route::get('/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'show'])->name('cellar_bottle.show')->middleware('auth');
Route::put('/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'drink'])->name('cellar_bottle.drink')->middleware('auth');
Route::get('/create/cellar-bottle', [CellarBottleController::class, 'create'])->name('cellar_bottle.create')->middleware('auth');
Route::post('/create/cellar-bottle', [CellarBottleController::class, 'store'])->name('cellar_bottle.store')->middleware('auth');
Route::get('/edit/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'edit'])->name('cellar_bottle.edit')->middleware('auth');
Route::put('/edit/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'update'])->name('cellar_bottle.update')->middleware('auth');
Route::delete('/cellar-bottle/{cellarBottle}', [CellarBottleController::class, 'destroy'])->name('cellar_bottle.destroy')->middleware('auth');

// Routes pour l'inscription
Route::get('/register', [UserController::class, 'create'])->name('user.create');
Route::post('/register', [UserController::class, 'store'])->name('user.store');

// Route pour le dashboard de l'administrateur
Route::get('/users', [UserController::class, 'index'])->name('user.index')->middleware('auth');;
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show')->middleware('auth');
Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user.edit')->middleware('auth');
Route::put('/user/edit/{user}', [UserController::class, 'update'])->name('user.update')->middleware('auth');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy')->middleware('auth');

// Route pour le profil de l'utilisateur
Route::get('/auth/{user}', [AuthController::class, 'show'])->name('auth.show')->middleware('auth');
Route::get('/auth/edit/{user}', [AuthController::class, 'edit'])->name('auth.edit')->middleware('auth');
Route::put('/auth/edit/{user}', [AuthController::class, 'update'])->name('auth.update')->middleware('auth');
Route::delete('/auth/{user}', [AuthController::class, 'deleteProfile'])->name('auth.destroy')->middleware('auth');

// Route pour le mot de passe oublié
Route::get('/password/forgot', [UserController::class, 'forgot'])->name('user.forgot');
Route::post('/password/forgot', [UserController::class, 'email'])->name('user.email');
Route::get('/password/reset/{user}/{token}', [UserController::class, 'reset'])->name('user.reset');
Route::put('/password/reset/{user}/{token}', [UserController::class, 'resetUpdate'])->name('user.reset.update');

// Routes pour la connexion et la déconnexion
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/login', [AuthController::class, 'store'])->name('login.store');
Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');

// Route pour le scraper
Route::get('/test-scraper', [ScraperController::class, 'index']);

//  Routes pour gérer les bouteilles personalisées 
Route::get('/custom-bottles/create', [BottleController::class, 'createCustom'])->name('custom-bottles.create');
Route::post('/custom-bottles/store', [BottleController::class, 'storeCustom'])->name('custom-bottles.store');

