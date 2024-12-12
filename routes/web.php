<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
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


Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('data-center', [HomeController::class, 'data_center'])->name('data_center');
Route::get('calender', [HomeController::class, 'calender'])->name('calender');
Route::get('input-screen', [HomeController::class, 'input_screen'])->name('input_screen');
Route::get('Notifications', [HomeController::class, 'notifications'])->name('notifications');
Route::get('visual-queue-screen', [HomeController::class, 'visual_screen'])->name('visual_screen');
Route::get('visual-queue-screen-1', [HomeController::class, 'visual_screen_1'])->name('visual_screen_1');
Route::get('visual-queue-screen-2', [HomeController::class, 'visual_screen_2'])->name('visual_screen_2');
Route::get('add-user', [HomeController::class, 'add_user'])->name('add_user');

#login route
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('loginuser', [LoginController::class, 'loginuser'])->name('loginuser');
