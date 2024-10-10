<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckMiddleware;
use Illuminate\Support\Facades\Auth;

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
    if (session()->has('success') && session()->get('success')) {
        return 'chưa đủ 18 tuổi để xem phim';
    }
});
Route::get('/movies', function () {
    return 'đủ tuổi xem phim';
})->middleware(CheckMiddleware::class);
Route::get('login', [AuthController::class, 'showFormLogin'])->name('formlogin');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'showFormRegister']);
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::get('/dashboard', function () {
    return 'đây là trang dashbord';
})->middleware('auth');
Route::get('/showFormforgot', [AuthController::class, 'showformforgot'])->name('showformforgot');
Route::post('/forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::get('/showFormOtp', [AuthController::class, 'showOtpForm'])->name('showOtpForm');
Route::post('/Otp', [AuthController::class, 'Otp'])->name('Otp');
Route::get('/showFormRest', [AuthController::class, 'showFormRest'])->name('showFormRest');
Route::post('/reset', [AuthController::class, 'reset'])->name('reset');



Route::middleware(['auth'])->group(function () {
    // Routes cho admin
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/order', function () {
            return view('admin.order');
        });
        Route::get('/product', function () {
            return view('admin.product');
        });
    });

    // Routes cho nhân viên
    Route::middleware(['role:personnel'])->group(function () {
        Route::get('/order', function () {
            return view('admin.order'); // Nếu personnel cũng có quyền xem order
        });
    });

    // Routes cho tất cả người dùng
    Route::middleware(['role:user'])->group(function () {
        Route::get('/profile', function () {
            return view('admin.profile');
        });
    });
});




