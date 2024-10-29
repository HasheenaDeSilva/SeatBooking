@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header text-center">
                    <h4 class="mb-0">{{ __('Intern Registration') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('intern.register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="intern_name" class="form-label">Intern Name:</label>
                            <input type="text" id="intern_name" name="intern_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="intern_id" class="form-label">Intern ID:</label>
                            <input type="text" id="intern_id" name="intern_id" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>

                    <div class="text-center mt-3">
                        <p class="text-muted">Already have an account? <a href="{{ route('intern.login') }}" class="text-primary">Login Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
