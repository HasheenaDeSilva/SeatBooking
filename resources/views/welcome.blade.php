
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Select Your Role</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .selection-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 50px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 100px;
            margin-bottom: 140px;
        }
        .btn-block {
            width: 100%;
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
                    <!-- You can add links here if needed -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container selection-container text-center">
        <h1 class="display-4 text-primary">Choose Your Role</h1>
        <p class="lead text-muted">Please select whether you're an Intern or Admin to proceed.</p>
        <hr class="my-4">

        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('selection.handle') }}" method="POST">
                    @csrf
                    <button type="submit" name="user_type" value="intern" class="btn btn-primary btn-lg btn-block mb-4">Intern</button>
                    <button type="submit" name="user_type" value="admin" class="btn btn-secondary btn-lg btn-block">Admin</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')
</body>
</html>
