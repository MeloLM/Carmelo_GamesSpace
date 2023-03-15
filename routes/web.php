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
Route::get('/profile', [FrontController::class,'profile'])->name('profile');
Route::put('/profile/avatar/{user}', [FrontController::class, 'changeAvatar'])->name('changeAvatar');

//ROUTE GAMES
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
Route::get('/console/create', [ConsoleController::class, 'create'])->name('console.create');
Route::post('console/store', [ConsoleController::class, 'store'])->name('console.store');
Route::get('/console/index', [ConsoleController::class, 'index'])->name('console.index');
Route::get('/console/show/{console}', [ConsoleController::class, 'show'])->name('console.show');
Route::get('/console/edit/{console}', [ConsoleController::class, 'edit'])->name('console.edit');
Route::put('/console/update/{console}', [ConsoleController::class, 'update'])->name('console.update');
Route::post('/console/destroy/{console}', [ConsoleController::class, 'destroy'])->name('console.destroy');