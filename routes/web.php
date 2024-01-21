<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataLogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengaturanController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Login
Route::get('/login', function () {
    return view('auth.login');
  })->name('login');

  Route::post('/login', [AuthController::class, 'login'])->name('post.login');

  // Register
  Route::get('/register', function () {
    return view('auth.register');
  })->name('register');

  Route::post('/register', [AuthController::class, 'register'])->name('post.register');

  Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/data-log', [DataLogController::class, 'index'])->name('data-log');
    Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  });
