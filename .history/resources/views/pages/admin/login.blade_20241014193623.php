@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                  
                    <div class="card-body">
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="admin_id" class="form-label">Admin ID</label>
                                <input type="text" name="admin_id" id="admin_id" class="form-control" placeholder="Enter Admin ID" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <input type="checkbox" id="remember" name="remember" class="me-1">
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
                        <div class="text-center mt-3">
                            <p>Don't have an account? <a href="{{ route('admin.register') }}" class="text-primary">Register Here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
