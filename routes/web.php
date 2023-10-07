<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', WelcomeController::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('order', [ProfileController::class, 'create'])->name('createOrder');
    Route::post('order', [ProfileController::class, 'store'])->name('storeOrder');
});

Route::middleware('ProfileUser')->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::delete('profile/{id}', [ProfileController::class, 'destroy'])->where(['id', '[0-9]+'])->name('deleteOrder');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'login'])->name('login');
    Route::post('login', [LoginController::class, 'authenficate'])->name('authenficate');

    Route::get('register', [RegisterController::class, 'getRegister'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
});

Route::middleware('admin')->group(function () {
    Route::get('admin', [AdminController::class, 'index'])->name('admin');
    Route::put('add-category', [OrderController::class, 'store'])->name('createCategory');

    Route::get('manage-categories', [OrderController::class, 'category'])->name('manage.categories');
    Route::get('manage-statuses', [OrderController::class, 'status'])->name('manage.statuses');

    //Поменять статус на решена
    Route::get('edit-status-completed/{id}', [OrderController::class, 'formStatusCompleted'])->name('form.status.completed');
    Route::patch('edit-status-completed/{id}', [OrderController::class, 'editStatusOnComplete'])->name('edit.status.completed');

    //Поменять статус на отклонена
    Route::get('edit-status-cancel/{id}', [OrderController::class, 'formStatusCancel'])->name('form.status.cancel');
    Route::patch('edit-status-cancel/{id}', [OrderController::class, 'editStatusOnCancel'])->name('edit.status.cancel');

    Route::delete('manage-categories/{id}', [OrderController::class, 'destroy'])->where(['id', '[0-9]+'])->name('deleteCategory');
});

