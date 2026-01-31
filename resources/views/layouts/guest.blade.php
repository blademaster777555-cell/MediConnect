<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MediConnect') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            border: none;
        }
        .auth-logo {
            font-size: 2rem;
            font-weight: 700;
            color: #0d6efd;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
            border-color: #86b7fe;
            background-color: #fff;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background: linear-gradient(45deg, #0d6efd, #6610f2);
            border: none;
        }
        .btn-primary:hover {
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-5">
                <div class="card auth-card p-4 p-md-5">
                    <div class="text-center mb-4">
                        <a href="/" class="text-decoration-none">
                            <i class="bi bi-heart-pulse-fill text-danger fs-1"></i>
                        </a>
                        <h2 class="fw-bold mt-2 text-dark">MediConnect</h2>
                        <p class="text-muted">{{ __('Comprehensive Healthcare') }}</p>
                    </div>

                    {{ $slot }}
                </div>
                <div class="text-center mt-4 text-white">
                    <small>&copy; {{ date('Y') }} MediConnect. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
