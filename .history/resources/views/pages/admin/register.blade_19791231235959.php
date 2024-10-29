@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded">
                <div class="card-body p-4">
                   <form action="{{ route('admin.register') }}" method="POST">
    @csrf
    <label for="admin_name">Admin Name:</label>
    <input type="text" id="admin_name" name="admin_name" required>

    <label for="admin_id">Admin ID:</label>
    <input type="text" id="admin_id" name="admin_id" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" required>

    <button type="submit">Register</button>
</form>

                </div>
            </div>
            <div class="text-center mt-3">
                <p class="text-muted">Already have an account? <a href="{{ route('admin.login') }}" class="text-primary">Login here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
