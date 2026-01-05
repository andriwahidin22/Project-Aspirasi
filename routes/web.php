<?php
// routes/web.php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Landing page / Home
Route::get('/', [AuthController::class, 'index'])->name('landing');

// Authentication routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public file access
Route::get('/storage/bukti/{filename}', function ($filename) {
    $path = storage_path('app/public/bukti/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->name('view.bukti');

Route::get('/storage/ktm/{filename}', function ($filename) {
    $path = storage_path('app/public/ktm/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->name('view.ktm');

// Mahasiswa routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        
        Route::prefix('complaints')->name('complaints.')->group(function () {
            Route::get('/', [ComplaintController::class, 'indexMahasiswa'])->name('index');
            Route::get('/create', [ComplaintController::class, 'create'])->name('create');
            Route::post('/', [ComplaintController::class, 'store'])->name('store');
            Route::get('/{complaint}', [ComplaintController::class, 'show'])->name('show');
            Route::get('/{complaint}/edit', [ComplaintController::class, 'edit'])->name('edit');
            Route::put('/{complaint}', [ComplaintController::class, 'update'])->name('update');
            Route::delete('/{complaint}', [ComplaintController::class, 'destroy'])->name('destroy'); // TAMBAHKAN INI
        });
    });
});

// Admin routes (protected dengan middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Complaints management
    Route::prefix('complaints')->name('complaints.')->group(function () {
        Route::get('/', [ComplaintController::class, 'indexAdmin'])->name('index');
        Route::get('/{complaint}', [ComplaintController::class, 'showAdmin'])->name('show');
        Route::patch('/{complaint}/status', [ComplaintController::class, 'updateStatus'])->name('update.status');
        Route::patch('/{complaint}/reject', [ComplaintController::class, 'reject'])->name('reject');
        
        // Export routes - konsisten dengan view
        Route::get('/export/pdf', [ComplaintController::class, 'exportPDF'])->name('export.pdf');
        Route::get('/{complaint}/export/pdf', [ComplaintController::class, 'exportSinglePDF'])->name('export.single');
    });
    
    // User management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'usersIndex'])->name('index');
        Route::get('/pending', [AdminController::class, 'usersPending'])->name('pending');
        Route::delete('/{user}', [AdminController::class, 'userDestroy'])->name('destroy');
        Route::post('/{user}/approve', [AdminController::class, 'approve'])->name('approve');
    });
});