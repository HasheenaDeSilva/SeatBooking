@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <input type="text" name="admin_id" placeholder="Admin ID" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <button type="submit">Login</button>
                        </form>
                        @if ($errors->has('login_error'))
                            <p>{{ $errors->first('login_error') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
