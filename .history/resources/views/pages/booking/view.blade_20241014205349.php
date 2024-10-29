@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">Your Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($bookings->isEmpty())
        <div class="alert alert-warning text-center">
            <p>No bookings found for your account.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="thead-light">
                    <tr>
                        <th>Booking ID</th>
                        <th>Intern Name</th>
                        <th>Intern ID</th>
                        <th>Seat Number</th>
                        <th>Date</th>
                        <th>Actions</th>
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
                                <!-- Delete Button -->
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                                </form>
                                <!-- Download Receipt Button -->
                                <a href="{{ route('booking.receipt', $booking->id) }}" class="btn btn-info btn-sm">Download Receipt</a>
                               

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
