@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center">
                        <h4>{{ __('Admin Login') }}</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="admin_id">Admin ID</label>
                                <input type="text" name="admin_id" id="admin_id" class="form-control" placeholder="Enter Admin ID" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>

                            @if ($errors->has('login_error'))
                                <div class="alert alert-danger text-center mt-3">
                                    {{ $errors->first('login_error') }}
                                </div>
                            @endif

                            <div class="text-center mt-3">
                                <a href="{{ route('password.request') }}">Forgot your password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
