<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ApprovisionnementController;

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

    // Routes pour les produits
    Route::prefix('produits')->name('produits.')->middleware('role:Administrateur|Gestionnaire')->group(function () {
        Route::get('/', [ProduitController::class, 'index'])->name('index');
        Route::get('/create', [ProduitController::class, 'create'])->name('create');
        Route::post('/', [ProduitController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProduitController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProduitController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProduitController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les fournisseurs
    Route::prefix('fournisseurs')->name('fournisseurs.')->middleware('role:Administrateur|Gestionnaire')->group(function () {
        Route::get('/', [FournisseurController::class, 'index'])->name('index');
        Route::get('/create', [FournisseurController::class, 'create'])->name('create');
        Route::post('/', [FournisseurController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FournisseurController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FournisseurController::class, 'update'])->name('update');
        Route::delete('/{id}', [FournisseurController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les catégories 
    Route::prefix('categories')->name('categories.')->middleware('role:Administrateur|Gestionnaire')->group(function () {
        Route::get('/', [CategorieController::class, 'index'])->name('index');
        Route::get('/create', [CategorieController::class, 'create'])->name('create');
        Route::post('/', [CategorieController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategorieController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategorieController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategorieController::class, 'destroy'])->name('destroy');
    });

    //routes for Approvisionnements
    Route::prefix('approvisionnements',)->name('approvisionnements.')->middleware('role:Administrateur|Gestionnaire')->group(function () {
        Route::get('/', [ApprovisionnementController::class, 'index'])->name('index');
        Route::get('/create', [ApprovisionnementController::class, 'create'])->name('create');
        Route::post('/', [ApprovisionnementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ApprovisionnementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ApprovisionnementController::class, 'update'])->name('update');
        Route::delete('/{id}', [ApprovisionnementController::class, 'destroy'])->name('destroy');
    });

    // Routes pour les notifications
    Route::get('/notifications', function () {
        // Fetch unread notifications with pagination (e.g., 10 per page)
        $notifications = auth()->user()->unreadNotifications()->paginate(3);
        return view('notifications.index', compact('notifications'));
    })->name('notifications');

    // Mark all notifications as read
    Route::get('/notifications/read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.read');

    // Mark a specific notification as read
    Route::post('/notifications/{id}/read', function ( $id) {
        $notification = auth()->user()->unreadNotifications()->find($id);
        if($notification){
            $notification->markAsRead();
        }
        return redirect()->back();
    })->name('notification.read');
    
});


require __DIR__.'/auth.php';
