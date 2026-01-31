<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <footer class="bg-dark text-light py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold text-primary">MediConnect</h5>
                <p>The leading online medical appointment platform.</p>
                <p><i class="bi bi-geo-alt"></i> 123 ABC Street, District 1, HCMC</p>
                <p><i class="bi bi-envelope"></i> contact@mediconnect.com</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="text-uppercase fw-bold text-primary">Sitemap</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-light text-decoration-none">→ {{ __('Home') }}</a></li>
                    <li><a href="{{ route('doctors.index') }}" class="text-light text-decoration-none">→ {{ __('Find Doctors') }}</a></li>
                    <li><a href="{{ route('about') }}" class="text-light text-decoration-none">→ {{ __('About Us') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">→ {{ __('Contact') }}</a></li>
                    @auth
                        <li><a href="{{ route('my.appointments') }}" class="text-light text-decoration-none">→ {{ __('My Appointments') }}</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-light text-decoration-none">→ {{ __('Patient Login') }}</a></li>
                        <li><a href="{{ route('login') }}" class="text-light text-decoration-none">→ {{ __('Doctor Login') }}</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-md-4">
                <h5 class="text-uppercase fw-bold text-primary">{{ __('Policies') }}</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light text-decoration-none">{{ __('Terms of Use') }}</a></li>
                    <li><a href="#" class="text-light text-decoration-none">{{ __('Privacy Policy') }}</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center pt-3 border-top border-secondary">
            <small>&copy; {{ date('Y') }} MediConnect. Project for Aptech.</small>
        </div>
    </div>
</footer>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
