<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Models\Transaction;
use Maatwebsite\Excel\Facades\Excel;

// Login, Register, Forgotpassword dan Logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login-user');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register-user', [AuthController::class, 'registerUser'])->name('register-user');
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot.password.send');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password.post');
// Home dan Dashboard
Route::get('/', function () {
    return view('home', ['title' => 'HOME']);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'], )->name('dashboard');
    // Photo Profile
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.update');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Product
    Route::resource('product', ProductController::class);
    // admin
    Route::resource('admin', UserController::class);
    // Member
    Route::resource('member', MemberController::class);
    Route::patch('/member/{id}/toggle-status', [MemberController::class, 'toggleStatus'])->name('member.toggleStatus');
    // Category
    Route::resource('category', CategoryController::class);
    // Discount
    Route::resource('discount', DiscountController::class);
    // Keranjang
    Route::resource('cart', CartController::class);
    Route::post('/cart/bulk-action', [CartController::class, 'bulkAction'])->name('cart.bulkAction');
    Route::post('/cart/scan', [CartController::class, 'scan'])->name('cart.scan');
    Route::post('/cart/clearExpired', [CartController::class, 'clearExpired'])->name('cart.clearExpired');
    Route::post('/cart/extend-time', [CartController::class, 'extendTime'])->name('cart.extendTime');
    // Transaksi
    Route::resource('transaction', TransactionController::class);
    Route::post('/transaction/store', [TransactionController::class, 'store'])->middleware('auth');
    Route::post('/transaction/store-from-cart', [TransactionController::class, 'storeFromCart'])->name('transaction.storeFromCart');
    // Route::get('/invoice/{ids}', [TransactionController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/invoice/{ids}', [TransactionController::class, 'showInvoice'])->name('invoice.show');
    Route::get('/invoice/{ids}/download', [TransactionController::class, 'downloadInvoicePdf'])->name('invoice.download');
    Route::post('/transaction/{transaction}/sendWa', [TransactionController::class, 'sendWhatsappMessage'])->name('transaction.sendWhatsApp');
    Route::get('/transaction/download/pdf', [TransactionController::class, 'downloadPdf'])->name('transaction.downloadPdf');
    // exel & pdf export
    Route::get('transactions/export', [TransactionController::class, 'export'])->name('transaction.export');
    Route::get('/transactions/export-pdf', [TransactionController::class, 'exportPdf'])->name('transaction.exportPdf');
    // delete transaction
    Route::delete('/transaction-all', [TransactionController::class, 'destroyAll'])->name('transaction.destroyAll');
});
