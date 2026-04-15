<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\DistributorController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// // --- TES LOGGING ---
// Route::get('/test-log', function () {
//     Log::info('===== INI ADALAH TES LOGGING =====');
//     Log::error('===== INI ADALAH TES LOGGING SEBAGAI ERROR =====');
//     return 'Logging test has been executed. Please check your storage/logs/laravel.log file.';
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    // // Route AWAL (aman)
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route BARU (rentan)
    Route::get('/profile/{id}', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route baru khusus untuk pembayaran
    // Route::patch('/profile/payment', action: [ProfileController::class, 'updatePayment'])->name('profile.payment.update');
    Route::patch('/profile/payment', [ProfileController::class, 'updatePayment'])->name('profile.payment.update');


    Route::get('/books/request', [BookController::class, 'requestForm'])->name('books.request.form');
    Route::post('/books/request', [BookController::class, 'requestStore'])->name('books.request.store');

    // Route untuk buku (aman)
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


    // Route untuk keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Route untuk update software (rentan)
    Route::get('/admin/update', [AdminController::class, 'showUpdateForm'])->name('admin.update.form');
    Route::post('/admin/update', [AdminController::class, 'performUpdate'])->name('admin.update.perform');

    // Route untuk melihat avatar user (rentan)
    Route::get('/profile/{id}/avatar', [ProfileController::class, 'showAvatar'])->name('profile.avatar');

    // Route untuk cetak invoice (rentan)
    Route::get('/cart/invoice', [CartController::class, 'generateInvoice'])->name('cart.invoice');
});

// Route ini rentan karena hanya butuh login, tidak butuh role 'admin'
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/user/update-role', [AdminController::class, 'updateRole'])->name('admin.user.updateRole');
Route::get('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');

Route::get('/admin/books', [AdminBookController::class, 'index'])->name('admin.books.index');
Route::get('/admin/books/create', [AdminBookController::class, 'create'])->name('admin.books.create');
Route::post('/admin/books/update', [AdminBookController::class, 'update'])->name('admin.books.update');
Route::get('/admin/books/delete/{id}', [AdminBookController::class, 'delete'])->name('admin.books.delete');
Route::post('/admin/books', [AdminBookController::class, 'store'])->name('admin.books.store');

Route::get('/distributor', [DistributorController::class, 'index'])->name('distributor.index');
Route::post('/distributor/sync', [DistributorController::class, 'sync'])->name('distributor.sync');
Route::get('/api/distributor', function (\Illuminate\Http\Request $request) {
    $data = [
        1 => [
            ['name' => 'Distributor A', 'region' => 'Java'],
            ['name' => 'Distributor B', 'region' => 'Bali'],
        ],
        2 => [
            ['name' => 'Distributor C', 'region' => 'Jakarta'],
            ['name' => 'Distributor D', 'region' => 'Lombok'],
        ],
    ];
    return response()->json($data[$request->id] ?? []);
});

Route::get('/internal/delete-book', function (\Illuminate\Http\Request $request) {
    if ($request->ip() !== '127.0.0.1') {
        abort(403, 'Forbidden');
    }

    $id = $request->id;

    \Illuminate\Support\Facades\DB::delete("DELETE FROM books WHERE id = $id");

    return "Book deleted: " . $id;
});
// Route untuk memicu error demi demonstrasi A02
Route::get('/debug-error', function () {
    // Memicu error "Division by zero"
    return 1 / 0;
});

// Route::get('/test-500', function () {
//     $x = 1 / 0; // Ini akan menyebabkan error 500
// });
// SOLUSI PASTI: Catch-all route untuk memaksa 404 masuk ke Laravel
// Route::any('/{any}', function () {
//     // Kita lempar exception 404 secara manual, sehingga Laravel yang menanganinya
//     throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException('Halaman tidak ditemukan.');
// })->where('any', '.*');

require __DIR__ . '/auth.php';
