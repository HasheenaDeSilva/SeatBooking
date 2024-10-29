<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seat Booking System</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
        }

        .welcome-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
            margin-bottom: 210px;
            transition: transform 0.2s;
        }

        .text-primary {
            color: #007bff;
        }

        .lead {
            font-size: 1.25rem;
            font-weight: 300;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            margin-top: 100px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('intern.login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="nav-link" href="{{ route('intern.register') }}">{{ __('Register') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container welcome-container text-center">
        <h1 class="display-4 text-primary">Welcome to the Seat Booking System</h1>
        <p class="lead text-muted">Easily reserve your seats and enhance your internship experience!</p>
        <hr class="my-4">
        <p class="text-secondary">Efficiently book your preferred seats for a comfortable and productive workday.</p>
    </div>


  <!-- Footer -->
  @include('partials.footer')
</body>
</html>
