@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-body p-4">
                    <form action="{{ route('admin.register') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="admin_name" class="form-label">Admin Name:</label>
                            <input type="text" id="admin_name" name="admin_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="admin_id" class="form-label">Admin ID:</label>
                            <input type="text" id="admin_id" name="admin_id" class="form-control" required>
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

                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted">Already have an account? <a href="{{ route('admin.login') }}" class="text-primary">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection