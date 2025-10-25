<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\User\DashboardController as UserDashboard;


Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// User Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboard::class, 'index'])->name('user.dashboard');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('exams', ExamController::class);
    Route::resource('questions', QuestionController::class)->except(['index', 'show']);
    // optionally route to manage options or bulk import
    Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
});


Route::prefix('user')->name('user.')->middleware(['auth', 'user'])->group(function () {
    Route::get('exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::post('exams/{exam}/start', [ExamController::class, 'start'])->name('exams.start');
    Route::get('take/{userExam}', [ExamController::class, 'take'])->name('exams.take');
    Route::post('take/{userExam}/answer', [ExamController::class, 'saveAnswer'])->name('exams.answer');
    Route::post('take/{userExam}/submit', [ExamController::class, 'submit'])->name('exams.submit');
    Route::get('result/{userExam}', [ExamController::class, 'result'])->name('exams.result');
});
