@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form action="{{ route('intern.register') }}" method="POST">
                            @csrf
                            <input type="text" name="intern_name" placeholder="Intern Name" required>
                            <input type="text" name="intern_id" placeholder="Intern ID" required>
                            <input type="email" name="email" placeholder="Email" required>
                            <input type="password" name="password" placeholder="Password" required>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            <button type="submit">Register</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
