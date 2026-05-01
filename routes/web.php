<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ExamController as UserExamController;
use App\Http\Controllers\User\ResultController as UserResultController;
use App\Http\Controllers\User\ProfileController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // User routes
    Route::middleware('user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        // Exam routes - REMOVED the middleware temporarily
        Route::get('/exams', [UserExamController::class, 'available'])->name('exams.available');
        Route::get('/exam/{exam}/instructions', [UserExamController::class, 'instructions'])->name('exam.instructions');
        Route::get('/exam/{exam}/start', [UserExamController::class, 'start'])->name('exam.start');
        // Remove ->middleware('prevent.exam.reattempt')
        Route::get('/exam/attempt/{attempt}', [UserExamController::class, 'take'])->name('exam.take');
        Route::post('/exam/attempt/{attempt}/auto-save', [UserExamController::class, 'autoSave'])->name('exam.auto-save');
        Route::post('/exam/attempt/{attempt}/submit', [UserExamController::class, 'submit'])->name('exam.submit');

        // Result routes
        Route::get('/results', [UserResultController::class, 'index'])->name('results.index');
        Route::get('/results/{result}', [UserResultController::class, 'show'])->name('results.show');

        // Profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
// Admin routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Category management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    // Exam management
    Route::resource('exams', App\Http\Controllers\Admin\ExamController::class);
    Route::post('/exams/{exam}/toggle-status', [App\Http\Controllers\Admin\ExamController::class, 'toggleStatus'])->name('exams.toggle-status');

    // Question management
    Route::prefix('exams/{exam}')->group(function () {
        Route::resource('questions', App\Http\Controllers\Admin\QuestionController::class);
        Route::get('/questions/bulk-upload', [App\Http\Controllers\Admin\QuestionController::class, 'bulkUpload'])->name('questions.bulk-upload');
        Route::post('/questions/bulk-upload', [App\Http\Controllers\Admin\QuestionController::class, 'processBulkUpload'])->name('questions.process-bulk-upload');
    });

    // User management
    Route::resource('users', App\Http\Controllers\Admin\UserManagementController::class);

    // Results
    Route::get('/results', [App\Http\Controllers\Admin\ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{result}', [App\Http\Controllers\Admin\ResultController::class, 'show'])->name('results.show');
    Route::get('/results/export/csv', [App\Http\Controllers\Admin\ResultController::class, 'export'])->name('results.export');
});

// Home route
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
});
