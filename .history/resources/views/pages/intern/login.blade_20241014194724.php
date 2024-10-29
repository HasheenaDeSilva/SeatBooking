@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-header text-center">
                    <h4 class="mb-0">{{ __('Intern Login') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('intern.login') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="intern_id" class="form-label">Intern ID:</label>
                            <input type="text" id="intern_id" name="intern_id" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div>
                                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember Me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-primary">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    @if ($errors->has('login_error'))
                        <div class="alert alert-danger mt-3 text-center">
                            {{ $errors->first('login_error') }}
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <p>Or login with:</p>
                        <a href="{{ url('auth/facebook') }}" class="btn btn-outline-primary w-100 mb-2">Login with Facebook</a>
                        <a href="{{ url('auth/google') }}" class="btn btn-outline-danger w-100">Login with Google</a>
                    </div>

                    <div class="text-center mt-3">
                        <p class="text-muted">Don't have an account? <a href="{{ route('intern.register') }}" class="text-primary">Register Here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
