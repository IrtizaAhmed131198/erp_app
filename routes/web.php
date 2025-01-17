<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
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

Route::middleware(['auth', 'config.check'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('data-center', [HomeController::class, 'data_center'])->name('data_center');
    Route::get('data-center/{id}', [HomeController::class, 'data_center_edit'])->name('data_center_edit');
    Route::get('shipment-and-production', [HomeController::class, 'calender'])->name('calender');
    Route::get('input-screen', [HomeController::class, 'input_screen'])->name('input_screen');
    Route::get('notifications', [HomeController::class, 'notifications'])->name('notifications');
    Route::get('visual-queue-screen', [HomeController::class, 'visual_screen'])->name('visual_screen');
    Route::get('visual-queue-screen-1', [HomeController::class, 'visual_screen_1'])->name('visual_screen_1');
    Route::get('visual-queue-screen-2', [HomeController::class, 'visual_screen_2'])->name('visual_screen_2');
    Route::get('add-user', [HomeController::class, 'add_user'])->name('add_user');

    Route::post('post-data-center', [HomeController::class, 'post_data_center'])->name('post_data_center');
    Route::post('post-data-center-update/{id}', [HomeController::class, 'post_data_center_update'])->name('post_data_center_update');
    Route::post('manual-imput', [HomeController::class, 'manual_imput'])->name('manual_imput');
    Route::post('manual-imput-work', [HomeController::class, 'manual_imput_work'])->name('manual_imput_work');
    Route::post('manual-imput-out', [HomeController::class, 'manual_imput_out'])->name('manual_imput_out');
    Route::get('get-part-no-detail', [HomeController::class, 'get_part_no_detail'])->name('get_part_no_detail');
    Route::post('update-production-total', [HomeController::class, 'update_production_total'])->name('update_production_total');
    Route::post('create-order', [HomeController::class, 'create_order'])->name('create_order');
    Route::post('get-weeks', [HomeController::class, 'get_weeks'])->name('get_weeks');
    Route::post('add-shipment', [HomeController::class, 'add_shipment'])->name('add_shipment');
    Route::post('update-past-due', [HomeController::class, 'update_past_due'])->name('update_past_due');
    Route::post('save-shipment-data', [HomeController::class, 'save_shipment_data'])->name('save_shipment_data');
    Route::post('change-past-due', [HomeController::class, 'change_past_due'])->name('change_past_due');
    Route::post('update-week-or-month', [HomeController::class, 'update_week_or_month'])->name('update_week_or_month');
    Route::post('save-table-data', [HomeController::class, 'save_table_data'])->name('save_table_data');
    Route::post('save-table-data-2', [HomeController::class, 'save_table_data_2'])->name('save_table_data_2');
    Route::post('save-columns-preferences', [HomeController::class, 'save_columns_preferences'])->name('save_columns_preferences');

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('users-edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::post('users-update', [UserController::class, 'update'])->name('users.update');
    Route::delete('users-delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::post('save-user-configuration', [HomeController::class, 'saveUserConfiguration'])->name('save.user.configuration');
    Route::post('reset-user-configuration', [HomeController::class, 'resetUserConfiguration'])->name('reset.user.configuration');

    Route::get('create-shipment-order-not/{id}', [HomeController::class, 'create_shipment_order_not'])->name('create_shipment_order_not');
    Route::get('update-production-total-not/{id}', [HomeController::class, 'update_production_total_not'])->name('update_production_total_not');
    Route::get('add-shipment-not/{id}', [HomeController::class, 'add_shipment_not'])->name('add_shipment_not');

    Route::post('signin', [LoginController::class, 'signin'])->name('signin');

});
#login route
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::post('loginuser', [LoginController::class, 'loginuser'])->name('loginuser');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::post('addimg', [LoginController::class, 'addimg'])->name('addimg');
