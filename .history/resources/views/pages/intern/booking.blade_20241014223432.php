@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mt-5">Book Your Seat</h1>

    <!-- Display Intern Details -->
    <p class="text-center">Welcome, {{ session('intern_name') }} (ID: {{ session('intern_id') }})</p>

    <!-- Display validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Booking Form -->
    <form action="{{ route('intern.booking.store') }}" method="POST" id="booking-form">
    @csrf

    <!-- Date Picker for Selecting Booking Date -->
    <div class="form-group text-center">
        <label for="datepicker" class="font-weight-bold">Select Booking Date:</label>
        <input type="text" id="datepicker" name="date" class="form-control mx-auto" style="max-width: 400px;" placeholder="Select a Day" required>
        <small class="form-text text-muted">Choose a weekday between today and the next 7 days.</small>
    </div>

    <!-- Hidden input for intern ID -->
    <input type="hidden" id="intern_id" name="intern_id" value="{{ session('intern_id') }}">

    <!-- Seat Selection Layout -->
    <div class="text-center">
        <h4>Select Your Seat</h4>
        <div class="row justify-content-center mt-4">
            <div class="col-auto">
                <div class="circle" id="circle1" style="cursor:pointer;">
                    <!-- Specific Seats -->
                    <div class="seat" data-seat-number="A16">A16</div>
                    <div class="seat" data-seat-number="A6">A6</div>
                    <div class="seat" data-seat-number="V16">V16</div>
                    <div class="seat" data-seat-number="B6">B6</div>
                </div>
            </div>
            <div class="col-auto">
                <div class="circle" id="circle2" style="cursor:pointer;">
                    <!-- Additional Seats if necessary -->
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden input for selected seat (as JSON string) -->
    <input type="hidden" id="seat_number" name="seat_number" value="">

    <!-- Submit button -->
    <div class="text-center">
        <button type="button" class="btn btn-primary mt-4" id="confirm-booking">Book Seat</button>
        <a href="{{ route('booking.view') }}" class="btn btn-secondary mt-4">View My Bookings</a>
    </div>
</form>
</div>

<!-- Custom CSS -->
<style>
    body {
        background: none; /* Remove background image */
    }

    .circle {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 2px solid #ccc;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: border-color 0.3s;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        position: absolute; /* Positioning for custom placement */
    }

    .seat.selected {
        background-color: #4CAF50;
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(76, 175, 80, 0.5);
    }

    .seat.booked {
        background-color: #f44336;
        cursor: not-allowed;
        opacity: 0.6;
    }

    button {
        transition: background-color 0.3s, transform 0.3s;
    }

    button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .circle {
            width: 250px;
            height: 250px;
        }
        .seat {
            width: 35px;
            height: 35px;
        }
    }
</style>

<!-- jQuery UI for Date Picker and Seat Selection JS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
$(document).ready(function() {
    const selectedSeatInput = $('#seat_number');
    let selectedSeat = null;

    // Set up jQuery date picker with date range limits
    const today = new Date();
    const minDate = today;
    const maxDate = new Date();
    maxDate.setDate(today.getDate() + 7);

    $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        minDate: minDate,
        maxDate: maxDate,
        beforeShowDay: function(date) {
            const day = date.getDay();
            return [(day !== 0), '']; // Disable Sundays
        }
    });

    // Add click event for seats
    $('.seat').on('click', function () {
        if (!$(this).hasClass('booked')) {
            // Unselect previously selected seat
            if (selectedSeat && selectedSeat !== this) {
                $(selectedSeat).removeClass('selected');
            }

            // Toggle current seat selection
            $(this).toggleClass('selected');
            selectedSeat = $(this).hasClass('selected') ? this : null;

            // Update hidden input with the selected seat number as a JSON string
            if (selectedSeat) {
                selectedSeatInput.val(JSON.stringify([$(this).data('seat-number')])); // Send seat number as JSON
            } else {
                selectedSeatInput.val(""); // Clear seat number if none is selected
            }
        }
    });

    // Confirmation Modal Logic
    $('#confirm-booking').on('click', function() {
        if (!selectedSeat) {
            alert("Please select a seat before booking.");
            return;
        }

        const date = $('#datepicker').val();
        const seatNumber = $(selectedSeat).data('seat-number');

        // Show confirmation modal
        const confirmation = confirm(`Confirm booking for ${seatNumber} on ${date}?`);
        if (confirmation) {
            $('#booking-form').submit();
        }
    });
});
</script>

@endsection
