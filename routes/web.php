<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ClassController; // Tambahkan controller untuk Class
use Illuminate\Support\Facades\Auth;

// Route untuk halaman welcome (default)
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Route untuk halaman register dan proses registrasi
Route::get('/register', [UsersController::class, 'getRegisterPage'])->name('register_page');
Route::post('/register', [UsersController::class, 'register'])->name('register');

// Route untuk halaman login dan proses login
Route::get('/login', [UsersController::class, 'getLoginPage'])->name('login_page');
Route::post('/login', [UsersController::class, 'login'])->name('login');

// Route untuk halaman kelas (Class)
Route::get('/class', [UsersController::class, 'welcome'])->middleware('auth')->name('class_page');

// Route untuk menampilkan daftar kelas
Route::get('/classes', [ClassController::class, 'getAllClasses'])->name('classes.index');

// Route untuk form pembuatan kelas
Route::get('/class/create', function () {
    return view('create_class');
})->middleware('auth')->name('create_class_form');

// Route untuk menyimpan data kelas
Route::post('/class/create', [ClassController::class, 'createClass'])->name('create_class');

// Route untuk bergabung ke kelas
Route::post('/class/join/{classCode}', [ClassController::class, 'joinClass'])->name('join_class');

// Route untuk menghapus kelas
Route::delete('/class/delete/{classCode}', [ClassController::class, 'deleteClass'])->name('delete_class');

// Route untuk halaman tugas (TaskPage)
Route::get('/task-page', [UsersController::class, 'viewTaskPage'])->middleware('auth')->name('task_page');

// Route untuk halaman ganti password dan proses ganti password
Route::get('/change-password', [UsersController::class, 'getChangePasswordPage'])->middleware('auth')->name('change_password_page');
Route::post('/change-password', [UsersController::class, 'changePassword'])->middleware('auth')->name('change_password');

// Route untuk halaman error
Route::get('/error', function () {
    return view('error_page');
})->name('error_page');

// Route untuk halaman personal
Route::get('/personal', [UsersController::class, 'getPersonalPage'])->middleware('auth')->name('personal_page');

// Route untuk menampilkan video
Route::get('/video', function () {
    $path = resource_path('assets/p.mp4');
    return response()->file($path);
})->name('video');

// Route untuk logout
Route::post('/logout', function () {
    Auth::logout(); // Logout pengguna
    return redirect()->route('login_page')->with('success', 'Logout successful!');
})->name('logout');
