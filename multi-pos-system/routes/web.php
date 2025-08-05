<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Google OAuth Routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// Store Setup Routes
Route::middleware('auth')->group(function () {
    Route::get('/store/setup', [StoreController::class, 'setup'])->name('store.setup');
    Route::post('/store/setup', [StoreController::class, 'storeSetup'])->name('store.store-setup');
});

// Protected Routes
Route::middleware(['auth', 'check.store'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Store Management
    Route::get('/store', [StoreController::class, 'show'])->name('store.show');
    Route::get('/store/edit', [StoreController::class, 'edit'])->name('store.edit');
    Route::put('/store', [StoreController::class, 'update'])->name('store.update');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Customers
    Route::resource('customers', CustomerController::class);
    
    // POS System
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/add-item', [PosController::class, 'addItem'])->name('pos.add-item');
    Route::post('/pos/remove-item', [PosController::class, 'removeItem'])->name('pos.remove-item');
    Route::post('/pos/process-sale', [PosController::class, 'processSale'])->name('pos.process-sale');
    Route::get('/pos/search-products', [PosController::class, 'searchProducts'])->name('pos.search-products');
    
    // Sales
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
    Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    Route::get('/sales/{sale}/pdf', [SaleController::class, 'pdf'])->name('sales.pdf');
    
    // Reports
    Route::get('/reports', [SaleController::class, 'reports'])->name('reports.index');
    Route::get('/reports/sales', [SaleController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/products', [ProductController::class, 'productsReport'])->name('reports.products');
    Route::get('/reports/customers', [CustomerController::class, 'customersReport'])->name('reports.customers');
});

// Super Admin Routes
Route::middleware(['auth', 'super.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::post('/stores/{store}/suspend', [StoreController::class, 'suspend'])->name('stores.suspend');
    Route::post('/stores/{store}/activate', [StoreController::class, 'activate'])->name('stores.activate');
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');
});
