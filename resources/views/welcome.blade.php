<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen bg-base-100">
        <!-- Hero Section -->
        <div class="hero min-h-screen bg-gradient-to-br from-primary/20 to-secondary/20">
            <div class="hero-content text-center">
                <div class="max-w-md">
                    <h1 class="text-5xl font-bold">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                    <p class="py-6">
                        Your application is ready. Start building something amazing with Laravel and daisyUI.
                    </p>
                    @if (Route::has('login'))
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                    Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-secondary">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-base-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold">Getting Started</h2>
                    <p class="mt-4 text-base-content/70">
                        Everything you need to build your next great application
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Documentation Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                </svg>
                                Documentation
                            </h2>
                            <p>Laravel has wonderful documentation covering every aspect of the framework.</p>
                            <div class="card-actions justify-end">
                                <a href="https://laravel.com/docs" target="_blank" class="btn btn-primary btn-sm">
                                    Explore Docs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Laracasts Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                                Laracasts
                            </h2>
                            <p>Thousands of video tutorials on Laravel, PHP, and JavaScript development.</p>
                            <div class="card-actions justify-end">
                                <a href="https://laracasts.com" target="_blank" class="btn btn-primary btn-sm">
                                    Start Watching
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Laravel News Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                                </svg>
                                Laravel News
                            </h2>
                            <p>Stay up to date with the latest Laravel news, tutorials, and packages.</p>
                            <div class="card-actions justify-end">
                                <a href="https://laravel-news.com" target="_blank" class="btn btn-primary btn-sm">
                                    Read News
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- GitHub Card -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5" />
                                </svg>
                                GitHub
                            </h2>
                            <p>View and contribute to our project repository on GitHub.</p>
                            <div class="card-actions justify-end">
                                <a href="https://github.com/jlevi001/client-tracker" target="_blank" class="btn btn-primary btn-sm">
                                    View Repo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer footer-center p-10 bg-base-300 text-base-content">
            <div>
                <p>Copyright © {{ date('Y') }} - All rights reserved by {{ config('app.name', 'Laravel') }}</p>
            </div>
        </footer>
    </div>
</body>
</html>