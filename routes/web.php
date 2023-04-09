<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ConsoleController;

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

Route::get('/', [FrontController::class , 'homepage'])->name('homepage');
Route::get('/contact_us',[FrontController::class, 'contact_us'])->name('contact_us');
Route::post('/contact_us/submit', [FrontController::class, 'contact_us_submit'])->name('contact_us_submit');

//ROUTE USER
Route::get('/profile/{user?}', [UserController::class,'profile'])->name('profile');
Route::put('/profile/avatar/{user}', [UserController::class, 'changeAvatar'])->name('changeAvatar');
Route::put('/profile/avatar/{user}/delete',[UserController::class,'deleteAvatar'])->name('deleteAvatar');
Route::delete('/user/destroy',[UserController::class, 'destroy'])->name('user.destroy');


//ROUTE GAMES
Route::get('/games/index', [GameController::class, 'index'])->name('game.index');
Route::get('/games/show/{game}', [GameController::class,'show'])->name('game.show');
Route::get('/games/create',[GameController::class , 'create_game'])->name('createGame');
Route::post('/games/store', [GameController::class, 'store'])->name('games.store');
Route::get('/games/edit/{game}',[GameController::class, 'edit'])->name('game.edit');
Route::put('/games/update/{game}',[GameController::class, 'update'])->name('game.update');
Route::delete('/games/destroy/{game}',[GameController::class, 'destroy'])->name('game.destroy');

//ROTTE LOG
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');


//ROTTE CONSOLE
Route::get('/bossArea/create', [ConsoleController::class, 'create'])->name('console.create');
Route::post('bossArea/store', [ConsoleController::class, 'store'])->name('console.store');
Route::get('/bossArea/index', [ConsoleController::class, 'index'])->name('console.index');
Route::get('/bossArea/show/{console}', [ConsoleController::class, 'show'])->name('console.show');
Route::get('/bossArea/edit/{console}', [ConsoleController::class, 'edit'])->name('console.edit');
Route::put('/bossArea/update/{console}', [ConsoleController::class, 'update'])->name('console.update');
Route::delete('/bossArea/destroy/{console}', [ConsoleController::class, 'destroy'])->name('console.destroy');