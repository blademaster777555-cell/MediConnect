<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MediConnect - Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: 700;
            color: #0d6efd !important;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .card-shadow {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 15px;
        }
        .btn-primary {
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
        }
        .footer {
            background-color: #212529;
            color: #adb5bd;
            padding: 50px 0 20px;
        }
        .footer h5 {
            color: #ffffff;
            margin-bottom: 20px;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .footer a:hover {
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-heart-pulse-fill text-danger me-2 fs-4"></i>
                <span class="fw-bold">MediConnect</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">{{ __('Overview') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}" href="{{ route('admin.doctors.index') }}">{{ __('Manage Doctors') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active' : '' }}" href="{{ route('admin.patients.index') }}">{{ __('Manage Patients') }}</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('medical-content.*') ? 'active' : '' }}" href="{{ route('medical-content.index') }}">{{ __('News & Diseases') }}</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}" href="{{ route('cities.index') }}">{{ __('Manage Cities') }}</a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.feedbacks.*') ? 'active' : '' }}" href="{{ route('admin.feedbacks.index') }}">{{ __('Feedback') }}</a>
                        </li>
                    @elseif(Auth::check() && Auth::user()->role === 'doctor')
                        {{-- Doctor links are now in the sidebar --}}
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('doctors.index') ? 'active' : '' }}" href="{{ route('doctors.index') }}">{{ __('Find Doctors') }}</a>
                        </li>
                    @endif
                    @if(!Auth::check() || Auth::user()->role !== 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('news') ? 'active' : '' }}" href="{{ route('news') }}">{{ __('News') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">{{ __('About') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">{{ __('Contact') }}</a>
                    </li>
                    @endif
                </ul>

                <ul class="navbar-nav">
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item me-3 position-relative d-flex align-items-center">
                        <a class="nav-link" href="{{ route('admin.notifications.index') }}">
                            <i class="bi bi-bell-fill fs-5"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-count" style="display: none;">
                                0
                            </span>
                        </a>
                    </li>
                    @endif

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                     alt="Avatar" class="rounded-circle me-2" width="30" height="30" style="object-fit: cover;">
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
                                @if(Auth::user()->role === 'doctor')
                                    <li><a class="dropdown-item" href="{{ route('doctor.profile') }}">{{ __('Doctor Profile') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Account Settings') }}</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('My Profile') }}</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">{{ __('Logout') }}</a></li>
                            </ul>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold">MediConnect</h5>
                    <p>{{ __('Leading online medical appointment platform in Vietnam. Connecting patients with specialist doctors quickly and conveniently.') }}</p>
                    <div class="d-flex">
                        <a href="#" class="text-light me-3"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-light me-3"><i class="bi bi-twitter fs-5"></i></a>
                        <a href="#" class="text-light me-3"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-light"><i class="bi bi-linkedin fs-5"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 mb-4">
                    <h5 class="fw-bold">{{ __('Services') }}</h5>
                    <ul class="list-unstyled">
                        @if(!Auth::check() || Auth::user()->role !== 'doctor')
                        <li><a href="{{ route('doctors.index') }}">{{ __('Find Doctors') }}</a></li>
                        @endif
                        <li><a href="{{ route('news') }}">{{ __('Medical News') }}</a></li>
                        <li><a href="{{ route('about') }}">{{ __('About Us') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('Contact') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 mb-4">
                    <h5 class="fw-bold">{{ __('Support') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">{{ __('FAQ') }}</a></li>
                        <li><a href="#">{{ __('Guide') }}</a></li>
                        <li><a href="#">{{ __('Policy') }}</a></li>
                        <li><a href="#">{{ __('Terms') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 mb-4">
                    <h5 class="fw-bold">{{ __('Contact Us') }}</h5>
                    <p><i class="bi bi-geo-alt me-2"></i>{{ __('123 Đường ABC, Quận 1, TP.HCM') }}</p>
                    <p><i class="bi bi-telephone me-2"></i>(028) 1234 5678</p>
                    <p><i class="bi bi-envelope me-2"></i>contact@mediconnect.vn</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="row">
                <div class="col-md-6">
                    <p>&copy; 2025 MediConnect. {{ __('All rights reserved.') }}</p>
                </div>
                <div class="col-md-6 text-end">
                    <p>{{ __('Designed by') }} <a href="#" class="text-primary">MediConnect Team</a></p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function checkNotifications() {
                // ... (existing notification logic) ...
            }

            // Check immediately and then every 30 seconds
            if(document.getElementById('notification-count')) {
                // ...
            }
        });

        function confirmDelete(event, form) {
            event.preventDefault();
            Swal.fire({
                title: '{{ __("Are you sure?") }}',
                text: '{{ __("This action cannot be undone!") }}',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: '{{ __("Yes, delete it!") }}',
                cancelButtonText: '{{ __("Cancel") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
    </script>
    @stack('scripts')
</body>
</html>