<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\OliController;
use App\Http\Controllers\RemController;
use App\Http\Controllers\InternalController;
use App\Http\Controllers\LainnyaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\CetakPdfController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KirimStrukController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminBookingsController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\DetailProuctController;

/*
|--------------------------------------------------------------------------
| RUTE PUBLIK (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/message/post', [HomeController::class, 'message'])->name('message.post');

// Auth & Verifikasi
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/verify', [AuthController::class, 'showVerificationForm'])->name('verification.form');
Route::post('/verify', [AuthController::class, 'verifyCode'])->name('verification.verify');
Route::post('/verify/resend', [AuthController::class, 'resendCode'])->name('verification.resend');
Route::get('/generate-sitemap', [SitemapController::class, 'generate']); // Sitemap bisa dibuat publik

/*
|--------------------------------------------------------------------------
| RUTE UNTUK USER YANG LOGIN (User & Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Fitur Booking untuk User
    Route::get('/booking', [BookingController::class, 'create'])->name('booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('bookings.index');
});

/*
|--------------------------------------------------------------------------
| RUTE KHUSUS ADMIN (Hanya bisa diakses oleh Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {

    // Dashboard & Stok
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/stok', [StokController::class, 'index'])->name('stok');

    // CRUD Oli
    Route::get('/oli', [OliController::class, 'index'])->name('oli');
    Route::get('/oli/create', [OliController::class, 'create'])->name('oli.create');
    Route::post('/oli/store', [OliController::class, 'store'])->name('oli.store');
    Route::get('/oli/{id}/edit', [OliController::class, 'edit'])->name('oli.edit');
    Route::put('/oli/{id}', [OliController::class, 'update'])->name('oli.update');
    Route::delete('/oli/{id}', [OliController::class, 'destroy'])->name('oli.destroy');

    // CRUD Rem
    Route::get('/rem', [RemController::class, 'index'])->name('rem');
    Route::get('/rem/create', [RemController::class, 'create'])->name('rem.create');
    Route::post('/rem/store', [RemController::class, 'store'])->name('rem.store');
    Route::get('/rem/{id}/edit', [RemController::class, 'edit'])->name('rem.edit');
    Route::put('/rem/{id}', [RemController::class, 'update'])->name('rem.update');
    Route::delete('/rem/{id}', [RemController::class, 'destroy'])->name('rem.destroy');

    // CRUD Internal
    Route::get('/internal', [InternalController::class, 'index'])->name('internal');
    Route::get('/internal/create', [InternalController::class, 'create'])->name('internal.create');
    Route::post('/internal/store', [InternalController::class, 'store'])->name('internal.store');
    Route::get('/internal/{id}/edit', [InternalController::class, 'edit'])->name('internal.edit');
    Route::put('/internal/{id}', [InternalController::class, 'update'])->name('internal.update');
    Route::delete('/internal/{id}', [InternalController::class, 'destroy'])->name('internal.destroy');

    // CRUD Lainnya
    Route::get('/lainnya', [LainnyaController::class, 'index'])->name('lainnya');
    Route::get('/lainnya/create', [LainnyaController::class, 'create'])->name('lainnya.create');
    Route::post('/lainnya/store', [LainnyaController::class, 'store'])->name('lainnya.store');
    Route::get('/lainnya/{id}/edit', [LainnyaController::class, 'edit'])->name('lainnya.edit');
    Route::put('/lainnya/{id}', [LainnyaController::class, 'update'])->name('lainnya.update');
    Route::delete('/lainnya/{id}', [LainnyaController::class, 'destroy'])->name('lainnya.destroy');

    // Message
    Route::get('/message', [MessageController::class, 'index'])->name('message');

    // Kasir, Keranjang Belanja (Cart), dan Transaksi
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir.index');
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/update/{cart_id}', [CartController::class, 'update'])->name('update');
        Route::post('/remove/{cart_id}', [CartController::class, 'remove'])->name('remove');
        Route::get('/', [CartController::class, 'index'])->name('index');
    });
    Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transactions.store');

    // Riwayat & Laporan
    Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('transaksi.riwayat');
    Route::get('/transaksi/{transaction_id}/cetak', [CetakPdfController::class, 'cetakStruk'])->name('transaksi.cetak');
    Route::get('/laporan/keuangan/cetak', [LaporanController::class, 'cetakLaporanKeuangan'])->name('laporan.keuangan.cetak');
    Route::post('/transaksi/{transaction_id}/kirim', [KirimStrukController::class, 'kirim'])->name('transaksi.kirim');

    // Manajemen Booking oleh Admin
    Route::prefix('admin')->group(function () {
        Route::get('/booking', [AdminBookingsController::class, 'index'])->name('admin.booking');
        Route::get('/booking/show/{booking}', [AdminBookingsController::class, 'show'])->name('bookings.show');
        Route::post('/booking/{booking}/confirm', [AdminBookingsController::class, 'confirm'])->name('admin.bookings.confirm');
        Route::post('/booking/{booking}/cancel', [AdminBookingsController::class, 'cancel'])->name('admin.bookings.cancel');
    });

    // Pengeluaran
    Route::resource('pengeluaran', PengeluaranController::class)->except(['show']);
    Route::get('/pengeluaran/add', [PengeluaranController::class, 'create'])->name('pengeluaran.add');
    Route::post(uri:'/pengeluaran/store', action:[PengeluaranController::class, 'store'])->name('pengeluaran.store');

    // Detail Product
    Route::get('/detail-product', [DetailProuctController::class, 'index'])->name('detail.product');
});
