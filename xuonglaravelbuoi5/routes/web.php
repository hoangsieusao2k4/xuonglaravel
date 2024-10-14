<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

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


// Route bắt đầu giao dịch
Route::match(['get', 'post'], '/transaction/start', [TransactionController::class, 'startTransaction']);

// Route tiếp tục giao dịch
Route::get('/transaction/resume', [TransactionController::class, 'resumeTransaction']);

// Route hoàn thành giao dịch
Route::match(['get', 'post'], '/transaction/complete', [TransactionController::class, 'completeTransaction']);

// Route hủy giao dịch
Route::post('/transaction/cancel', [TransactionController::class, 'cancelTransaction']);
