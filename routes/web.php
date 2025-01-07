<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ApprovisionnementController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Route
Route::get('/dashboard', function () {
    $data = [
        'totalUsers' => App\Models\User::count(),
        'totalProducts' => App\Models\Produit::count(),
        'pendingOrders' => App\Models\Commande::where('statut', 'En cours')->count(),
        'activeSuppliers' => App\Models\Fournisseur::count(),
        'recentOrders' => App\Models\Commande::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
    ];

    return view('dashboard', compact('data'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/index', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// User Management Routes
Route::middleware(['auth'])->prefix('users')->name('users.')->group(function () {
    Route::middleware('can:manage users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');

        // Role management
        Route::get('/{id}/roles', [UserController::class, 'editRoles'])->name('roles.edit');
        Route::post('/{id}/roles', [UserController::class, 'updateRoles'])->name('roles.update');
    });
});

// Products Routes
Route::middleware(['auth'])->prefix('produits')->name('produits.')->group(function () {
    Route::middleware('can:view produits')->get('/', [ProduitController::class, 'index'])->name('index');
    Route::middleware('can:manage produits')->group(function () {
        Route::get('/create', [ProduitController::class, 'create'])->name('create');
        Route::post('/', [ProduitController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ProduitController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ProduitController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProduitController::class, 'destroy'])->name('destroy');
    });
});

// Categories Routes
Route::middleware(['auth'])->prefix('categories')->name('categories.')->group(function () {
    Route::middleware('can:view categories')->get('/', [CategorieController::class, 'index'])->name('index');
    Route::middleware('can:manage categories')->group(function () {
        Route::get('/create', [CategorieController::class, 'create'])->name('create');
        Route::post('/', [CategorieController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CategorieController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CategorieController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategorieController::class, 'destroy'])->name('destroy');
    });
});

// Fournisseurs Routes
Route::middleware(['auth'])->prefix('fournisseurs')->name('fournisseurs.')->group(function () {
    Route::middleware('can:view fournisseurs')->get('/', [FournisseurController::class, 'index'])->name('index');
    Route::middleware('can:manage fournisseurs')->group(function () {
        Route::get('/create', [FournisseurController::class, 'create'])->name('create');
        Route::post('/', [FournisseurController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [FournisseurController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FournisseurController::class, 'update'])->name('update');
        Route::delete('/{id}', [FournisseurController::class, 'destroy'])->name('destroy');
    });
});

// Commandes Routes
Route::middleware(['auth'])->prefix('commandes')->name('commandes.')->group(function () {
    Route::middleware('can:view commandes')->get('/', [CommandeController::class, 'index'])->name('index');
    Route::middleware('can:manage commandes')->group(function () {
        Route::get('/create', [CommandeController::class, 'create'])->name('create');
        Route::post('/', [CommandeController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [CommandeController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CommandeController::class, 'update'])->name('update');
        Route::delete('/{id}', [CommandeController::class, 'destroy'])->name('destroy');
    });
});

// Transactions Routes
Route::middleware(['auth'])->prefix('transactions')->name('transactions.')->group(function () {
    Route::middleware('can:view transactions')->get('/', [TransactionController::class, 'index'])->name('index');
    Route::middleware('can:export transactions')->get('/export', [TransactionController::class, 'export'])->name('export');
    Route::middleware('can:manage transactions')->get('/report', [TransactionController::class, 'generateReport'])->name('report');
});

// Factures Routes
Route::middleware(['auth'])->prefix('factures')->name('factures.')->group(function () {
    Route::middleware('can:view factures')->get('/', [FactureController::class, 'index'])->name('index');
    Route::middleware('can:manage factures')->get('/{facture}', [FactureController::class, 'show'])->name('show');
    Route::middleware('can:export factures')->get('/{facture}/pdf', [FactureController::class, 'generatePDF'])->name('pdf');
});

// Approvisionnements Routes
Route::middleware(['auth'])->prefix('approvisionnements')->name('approvisionnements.')->group(function () {
    Route::middleware('can:view approvisionnements')->get('/', [ApprovisionnementController::class, 'index'])->name('index');
    Route::middleware('can:manage approvisionnements')->group(function () {
        Route::get('/create', [ApprovisionnementController::class, 'create'])->name('create');
        Route::post('/', [ApprovisionnementController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ApprovisionnementController::class, 'edit'])->name('edit');
        Route::put('/{id}', [ApprovisionnementController::class, 'update'])->name('update');
        Route::delete('/{id}', [ApprovisionnementController::class, 'destroy'])->name('destroy');
    });
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

require __DIR__.'/auth.php';
