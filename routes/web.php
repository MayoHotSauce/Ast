<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AssetRequestController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\StockController;

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
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('barang', DataBarangController::class);
    Route::group(['middleware' => ['auth']], function () {
        Route::resource('maintenance', MaintenanceController::class);
        Route::put('/maintenance/{id}/complete', [MaintenanceController::class, 'complete'])->name('maintenance.complete');
        Route::put('maintenance/{maintenance}/update-status', [MaintenanceController::class, 'updateStatus'])->name('maintenance.updateStatus');
    });
});

// Test Route
Route::get('/test-barang', function() {
    return DaftarBarang::create([
        'name' => 'Test Item',
        'description' => 'Test Description',
        'room' => 'Ruang Utama',
        'category_id' => 1,
        'tahun_pengadaan' => 2024,
        'condition' => 'good',
        'status' => 'active'
    ]);
});

// PENGAJUAN ASSET
Route::middleware(['auth'])->group(function () {
    Route::get('/pengajuan', [AssetRequestController::class, 'index'])->name('pengajuan.index');
    Route::get('/pengajuan/create', [AssetRequestController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan', [AssetRequestController::class, 'store'])->name('pengajuan.store');
    Route::get('/pengajuan/{id}', [AssetRequestController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/{id}/approve/{token}', [AssetRequestController::class, 'approve'])->name('pengajuan.approve');
    Route::get('/pengajuan/{id}/decline/{token}', [AssetRequestController::class, 'decline'])->name('pengajuan.decline');
});

Route::get('/test-email', function() {
    Mail::raw('Test email', function($message) {
        $message->to('adityanathaniel44@gmail.com')
                ->subject('Test Email');
    });
    
    return 'Test email sent!';
});

// Public approval routes (no auth required)
Route::get('/approval/{id}/approve/{token}', [AssetRequestController::class, 'handleApproval'])
    ->name('approval.approve');
Route::get('/approval/{id}/decline/{token}', [AssetRequestController::class, 'handleDecline'])
    ->name('approval.decline');


// UPDATE COMPANY LOGO
Route::middleware(['auth'])->group(function () {
    Route::get('/company/logo/update', [CompanyController::class, 'showLogoForm'])
        ->name('company.logo.edit');

    Route::post('/company/logo/update', [CompanyController::class, 'updateLogo'])
        ->name('company.logo.update');
});

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang.index');

Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

Route::get('stock', [StockController::class, 'index'])->name('stock.index');
Route::post('stock/confirm', [StockController::class, 'confirm'])->name('stock.confirm');
