@extends('layouts.app')

@section('content')

    <h1>Your Bookings</h1>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if($bookings->isEmpty())
        <p>No bookings found for your account.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Intern Name</th>
                    <th>Intern ID</th>
                    <th>Seat Number</th>
                    <th>Date</th>
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
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this booking?');">Delete</button>
                            </form>

                            <!-- Download Receipt Button -->
                            <a href="{{ route('booking.receipt', $booking->id) }}" class="btn">Download Receipt</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
