<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ManifestController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\DepartureController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\OrderController;

// ─── Public Routes ─────────────────────────────────────────────────────────
Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::post('/daftar-sekarang', [FrontendController::class, 'storeLead'])->name('frontend.leads.store');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin Panel (all authenticated roles) ─────────────────────────────────
Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    // Dashboard — accessible by all roles but shows role-specific content
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Leads — superadmin, sales, agen, partner (scoped by role in controller)
    Route::middleware('role:superadmin,sales,agen,partner')->group(function () {
        Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
        Route::post('leads', [LeadController::class, 'store'])->name('leads.store');
        Route::post('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.update-status');
        Route::get('leads/export-csv', [LeadController::class, 'exportCsv'])->name('leads.export-csv');
    });

    // Orders — superadmin, sales, partner (agen tidak bisa akses orders)
    Route::middleware('role:superadmin,sales,partner')->group(function () {
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::get('orders/{order}/export-invoice', [OrderController::class, 'exportInvoice'])->name('orders.export-invoice');
    });

    // Packages — superadmin full CRUD, agen/partner view only
    Route::middleware('role:superadmin,agen,partner')->group(function () {
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('packages/{package}', [PackageController::class, 'show'])->name('packages.show');
    });

    // Superadmin-only routes
    Route::middleware('role:superadmin')->group(function () {
        // Packages CRUD (tambah/edit/hapus)
        Route::post('packages', [PackageController::class, 'store'])->name('packages.store');
        Route::get('packages/create', [PackageController::class, 'create'])->name('packages.create');
        Route::put('packages/{package}', [PackageController::class, 'update'])->name('packages.update');
        Route::delete('packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

        // Galleries
        Route::get('galleries', [GalleryController::class, 'index'])->name('galleries.index');
        Route::post('galleries', [GalleryController::class, 'store'])->name('galleries.store');
        Route::put('galleries/{gallery}', [GalleryController::class, 'update'])->name('galleries.update');
        Route::delete('galleries/{gallery}', [GalleryController::class, 'destroy'])->name('galleries.destroy');

        // Manifests
        Route::get('manifests', [ManifestController::class, 'index'])->name('manifests.index');
        Route::get('manifests/export-pdf', [ManifestController::class, 'exportPdf'])->name('manifests.export-pdf');
        Route::get('manifests/export-csv', [ManifestController::class, 'exportCsv'])->name('manifests.export-csv');
        Route::get('manifests/download-batch/{package}', [ManifestController::class, 'downloadBatchScans'])->name('manifests.download-batch');
        Route::post('manifests/{manifest}', [ManifestController::class, 'update'])->name('manifests.update');
        Route::post('manifests/{manifest}/toggle-doc', [ManifestController::class, 'toggleDocumentStatus'])->name('manifests.toggle-doc');
        Route::post('manifests/{manifest}/upload-scan', [ManifestController::class, 'uploadScan'])->name('manifests.upload-scan');
        Route::post('room-lists', [ManifestController::class, 'storeRoomList'])->name('room-lists.store');
        Route::post('manifests/{manifest}/plot-room', [ManifestController::class, 'plotRoom'])->name('manifests.plot-room');
        Route::post('manifests/{manifest}/transfer-room', [ManifestController::class, 'transferRoom'])->name('manifests.transfer-room');
        Route::post('manifests/{manifest}/plot-bus', [ManifestController::class, 'plotBus'])->name('manifests.plot-bus');
        Route::post('manifests/{manifest}/equipment', [ManifestController::class, 'updateEquipment'])->name('manifests.update-equipment');
        Route::get('manifests/export-room', [ManifestController::class, 'exportRoomListCsv'])->name('manifests.export-room');
        Route::get('manifests/export-bus', [ManifestController::class, 'exportBusSeaterCsv'])->name('manifests.export-bus');

        // Departures
        Route::get('departures', [DepartureController::class, 'index'])->name('departures.index');
        Route::get('departures/{package}', [DepartureController::class, 'show'])->name('departures.show');

        // User Management
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::post('users', [UserManagementController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

        // Testimonials
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class)->except('show');
    });
});
