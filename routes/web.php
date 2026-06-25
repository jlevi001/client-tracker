<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/register', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // User Management Routes - Using Livewire Component
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index')->middleware('can:manage users');
    
    // Client Management Routes - Using Livewire Component
    Route::get('/clients', function () {
        return view('clients.index');
    })->name('clients.index')->middleware('can:manage users');

    // Media Engine (Social Media / blog control panel). The Livewire component
    // calls the n8n webhooks server-side (secret attached in PHP), so no public
    // proxy routes are needed. Open to any logged-in user.
    Route::get('/mediaengine', function () {
        return view('mediaengine');
    })->name('mediaengine');
});
