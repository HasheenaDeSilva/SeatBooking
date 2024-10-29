@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">{{ __('Admin Login') }}</div>

                    <div class="card-body">
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="admin_id" class="font-weight-bold">Admin ID</label>
                                <input type="text" id="admin_id" name="admin_id" class="form-control" placeholder="Enter Admin ID" required autofocus>
                                @if ($errors->has('admin_id'))
                                    <small class="text-danger">{{ $errors->first('admin_id') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password" required>
                                @if ($errors->has('password'))
                                    <small class="text-danger">{{ $errors->first('password') }}</small>
                                @endif
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember Me</label>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>

                            @if ($errors->has('login_error'))
                                <div class="alert alert-danger text-center mt-3">
                                    {{ $errors->first('login_error') }}
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('password.request') }}" class="text-primary">Forgot Your Password?</a>
                </div>
            </div>
        </div>
    </div>
@endsection
