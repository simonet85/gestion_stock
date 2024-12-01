<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', [ProfileController::class, 'edit'])->name('profile.edit');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Routes for users and their roles
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index')->middleware('role:Administrateur|Gestionnaire');
        Route::get('/create', [UserController::class, 'create'])->name('create')->middleware('role:Administrateur|Gestionnaire');
        Route::post('/', [UserController::class, 'store'])->name('store')->middleware('role:Administrateur|Gestionnaire');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit')->middleware('role:Administrateur|Gestionnaire');
        Route::put('/{id}', [UserController::class, 'update'])->name('update')->middleware('role:Administrateur|Gestionnaire');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy')->middleware('role:Administrateur|Gestionnaire');

        // Role management for users
        Route::get('/{id}/roles', [UserController::class, 'editRoles'])->name('roles.edit')->middleware('role:Administrateur|Gestionnaire');
        Route::post('/{id}/roles', [UserController::class, 'updateRoles'])->name('roles.update')->middleware('role:Administrateur|Gestionnaire');


    });

    // Routes for administrators
    Route::prefix('admins')->name('admins.')->middleware('role:Administrateur')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');

        // Role management for administrators
        Route::get('/{id}/roles', [AdminController::class, 'editRoles'])->name('roles.edit');
        Route::post('/{id}/roles', [AdminController::class, 'updateRoles'])->name('roles.update');

        Route::get('/history', [ActivityController::class, 'index'])->name('history.index');

    });

    // Routes for managers
    Route::prefix('managers')->name('managers.')->middleware('role:Administrateur')->group(function () {
        Route::get('/', [ManagerController::class, 'index'])->name('index');
        Route::get('/create', [ManagerController::class, 'create'])->name('create');
        Route::post('/', [ManagerController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ManagerController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ManagerController::class, 'update'])->name('update');
        Route::delete('/{id}', [ManagerController::class, 'destroy'])->name('destroy');

        // Role management for managers
        Route::get('/{id}/roles', [ManagerController::class, 'editRoles'])->name('roles.edit');
        Route::post('/{id}/roles', [ManagerController::class, 'updateRoles'])->name('roles.update');
    });
});


require __DIR__.'/auth.php';
