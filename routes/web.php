<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;

// Auth

Route::get('login', [LoginController::class, 'create'])
    ->name('login')
    ->middleware('guest');

Route::post('login', [LoginController::class, 'store'])
    ->name('login.store')
    ->middleware('guest');

Route::delete('logout', [LoginController::class, 'destroy'])
    ->name('logout');

// Dashboard

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth');

Route::get('/500', function () {
   echo $oyster;
});

Route::resource('users', App\Http\Controllers\UsersController::class);

Route::resource('accounts', App\Http\Controllers\AccountController::class);

Route::resource('roles', App\Http\Controllers\RolesController::class);

Route::resource('locations', App\Http\Controllers\LocationController::class);

Route::resource('customers', App\Http\Controllers\CustomerController::class);

Route::resource('contacts', App\Http\Controllers\ContactController::class);

Route::resource('units', App\Http\Controllers\UnitController::class);

Route::resource('tasks', App\Http\Controllers\TaskController::class);

Route::resource('parts', App\Http\Controllers\PartController::class);

Route::resource('invoices', App\Http\Controllers\InvoiceController::class);

Route::resource('line-items', App\Http\Controllers\LineItemController::class);

