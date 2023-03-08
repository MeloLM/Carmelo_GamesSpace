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

Route::get('/', [GameController::class , 'homepage'])->name('homepage');

//ROUTE ADD GAMES
Route::get('/games',[GameController::class , 'create_game'])->name('createGame');
Route::post('/games/store', [GameController::class, 'store'])->name('games.store');

//ROTTE LOG
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/register', [UserController::class, 'register'])->name('register');

//ROTTE CONSOLE
Route::get('/console/create', [ConsoleController::class, 'create'])->name('console.create');
Route::post('console/store', [ConsoleController::class, 'store'])->name('console.store');
Route::get('/console/index', [ConsoleController::class, 'index'])->name('console.index');
Route::get('/console/show/{console}', [ConsoleController::class, 'show'])->name('console.show');