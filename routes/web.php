<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminVerificationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ItemController;


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

Route::get('/verification-required', [VerificationController::class, 'verificationRequired'])
    ->name('verification.required');

Route::get('/', function () {
        return redirect()->route('blog.index');
    })->middleware(['auth', 'verified'])->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user-verification', [AdminVerificationController::class, 'UserShow'])
        ->name('verification');
    Route::post('/user-verification/approve/{id}', [AdminVerificationController::class, 'UserApprove'])
        ->name('verification.approve');
    Route::post('/user-verification/deny/{id}', [AdminVerificationController::class, 'UserDeny'])
        ->name('verification.deny');
});

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/employees', [EmployeeController::class, 'indexEmployee'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'createEmployee'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'storeEmployee'])->name('employees.store');
        Route::delete('/employees/{id}', [EmployeeController::class, 'deleteEmployee'])->name('employees.destroy');
    });

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/users', [UserController::class, 'allUser'])->name('users.index');
        Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('users.destroy');
    });


Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show');
        Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
    });

Route::middleware(['auth', 'verified'])->group(function () {
        Route::resource('items', ItemController::class);
    });

require __DIR__.'/auth.php';