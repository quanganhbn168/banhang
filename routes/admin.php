<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\IntroController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Admin\BookingController;

// use App\Http\Controllers\ToggleController;

Route::middleware(['auth:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/toggle', [DashboardController::class, 'toggleField'])->name('toggle');
    Route::resource('intros', IntroController::class);

    Route::resource('categories', CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
      ->name('categories.toggle-status');
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('post-categories', PostCategoryController::class);
    Route::resource('posts', PostController::class);
    Route::resource('slides', SlideController::class);
    Route::resource('certificates', CertificateController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('service_categories', ServiceCategoryController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::resource('contacts', ContactController::class)->only(['index', 'destroy']);
    Route::resource('teams', TeamController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('orders', OrderController::class)->only([
        'index', 'show', 'destroy'
    ]);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Route để hiển thị trang lịch
    Route::get('/bookings/calendar', [BookingController::class, 'index'])->name('bookings.calendar');

    // Route API để lấy dữ liệu sự kiện cho lịch (thường dùng phương thức GET)
    Route::get('/bookings/events', [BookingController::class, 'getEvents'])->name('bookings.events');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');
});
