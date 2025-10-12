<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\ClientPageController;
use App\Http\Controllers\CheckoutController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Payment/Checkout routes
Route::get('/checkout/{transactionId}', [CheckoutController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout/{transactionId}/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
Route::get('/payment/{transactionId}/success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/{transactionId}/failed', [CheckoutController::class, 'paymentFailed'])->name('payment.failed');
Route::get('/payment/{transactionId}/status', [CheckoutController::class, 'paymentStatus'])->name('payment.status');
Route::post('/payment/{transactionId}/cancel', [CheckoutController::class, 'cancelPayment'])->name('payment.cancel');

// Authentication routes
Route::middleware('guest:company')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth:company')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
    });
    
    // Client routes
    Route::middleware(['check.role:client,admin'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'clientDashboard'])->name('client.dashboard');

        // Client pages
        Route::get('/dashboard/campaigns/create', [ClientPageController::class, 'createCampaign'])->name('client.campaigns.create');
        Route::get('/dashboard/templates', [ClientPageController::class, 'viewTemplates'])->name('client.templates');
        Route::get('/dashboard/users', [ClientPageController::class, 'manageUsers'])->name('client.users');
        Route::get('/dashboard/reports', [ClientPageController::class, 'viewReports'])->name('client.reports');
    });
    
    // Developer routes
    Route::middleware(['check.role:developer,admin'])->group(function () {
        Route::get('/api-documentation', function () {
            return redirect('/api/documentation');
        })->name('api.documentation');
    });
});
