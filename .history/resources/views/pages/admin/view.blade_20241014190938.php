@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">All Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.save') }}" method="POST">
        @csrf
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Intern Name</th>
                        <th>Intern ID</th>
                        <th>Seat Number</th>
                        <th>Booking Date</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->intern_name }}</td>
                            <td>{{ $booking->intern_id }}</td>
                            <td>{{ trim($booking->seat_number, '[]"') }}</td>
                            <td>{{ $booking->date }}</td>
                            <td>
                                <input type="hidden" name="attendances[{{ $booking->id }}][intern_name]" value="{{ $booking->intern_name }}">
                                <input type="hidden" name="attendances[{{ $booking->id }}][intern_id]" value="{{ $booking->intern_id }}">
                                <input type="hidden" name="attendances[{{ $booking->id }}][seat_number]" value="{{ $booking->seat_number }}">
                                <input type="hidden" name="attendances[{{ $booking->id }}][date]" value="{{ $booking->date }}">
                                <input type="checkbox" name="attendances[{{ $booking->id }}][is_present]" value="1"> <!-- Present -->
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success mt-3">Save Attendance</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('attendance.download') }}" class="btn btn-primary">Download Attendance Records</a>
    </div>
</div>
@endsection
