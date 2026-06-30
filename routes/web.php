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

    // Bulk Emailer — serves the self-contained HTML form (single editable file at
    // resources/emailer/emailer.html) inside a dashboard modal/iframe. The logged-in
    // user is injected as window.LINGO_SENDER so the n8n workflow sends the campaign
    // "as" that user (their @lingoit.net address; replies go to them). Open to any
    // logged-in user.
    Route::get('/emailer/form', function () {
        $html = file_get_contents(resource_path('emailer/emailer.html'));

        // Default sender = the logged-in user.
        $me = json_encode([
            'email' => auth()->user()->email,
            'name'  => auth()->user()->name,
        ], JSON_UNESCAPED_SLASHES);

        // Pickable senders = ACTIVE team members on @lingoit.net (the addresses the
        // n8n send-as can impersonate). Inactive employees (employment_end_date in
        // the past) are excluded automatically. Any logged-in user may choose who
        // to send as.
        $senders = \App\Models\User::orderBy('name')
            ->get(['name', 'email', 'employment_end_date'])
            ->filter(fn ($u) => $u->is_active
                && str_ends_with(strtolower((string) $u->email), '@lingoit.net'))
            ->map(fn ($u) => ['email' => $u->email, 'name' => $u->name])
            ->values()
            ->toJson(JSON_UNESCAPED_SLASHES);

        $html = str_replace(
            '</head>',
            '<script>window.LINGO_SENDER = ' . $me . '; window.LINGO_SENDERS = ' . $senders . ';</script></head>',
            $html
        );

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('X-Frame-Options', 'SAMEORIGIN');
    })->name('emailer.form');
});
