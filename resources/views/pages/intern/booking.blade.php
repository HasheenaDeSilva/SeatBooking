@extends('layouts.apps')

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
                <div class="circle" id="circle1" data-seat="A5" style="cursor:pointer;"></div>
            </div>
            <div class="col-auto">
                <div class="circle" id="circle2" data-seat="B6" style="cursor:pointer;"></div>
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
        background: none;
        background-color: #7fb8f5 /* Remove background image */
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

    .circle:hover {
        border-color: #007bff;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: white;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

   .seat.available {
    background-color: #4CAF50; /* green for available */
}

.seat.booked {
    background-color: #f44336; /* red for booked */
    cursor: not-allowed;
    opacity: 0.6;
}

.seat.selected {
    background-color: #FFA500; /* orange for selected */
    transform: scale(1.1);
    box-shadow: 0 0 15px rgba(255, 165, 0, 0.5);
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

<!-- Modify the Blade Template to Pass Booked Seats -->
@php
    $bookedSeats = json_encode($bookedSeats ?? []);
@endphp


<script>
$(document).ready(function() {
    const bookedSeats = {!! json_encode($bookedSeats ?? []) !!}; // Ensure this is an array of strings
    console.log("Booked Seats:", bookedSeats);
    const selectedSeatInput = $('#seat_number');
    let selectedSeat = null;

    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        onSelect: function(dateText) {
            // Send AJAX request to get booked seats
            $.ajax({
                url: '{{ route('get.booked.seats') }}',
                method: 'POST',
                data: {
                    date: dateText,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
    console.log("Booked Seats for selected date:", data);
    $('.seat').removeClass('booked selected');

    // Parse the JSON strings if necessary
    const bookedSeats = data.map(seat => JSON.parse(seat)[0]);

    // Mark the booked seats
    bookedSeats.forEach(function(seatNumber) {
        $(`.seat[data-seat-number="${seatNumber}"]`).addClass('booked');
    });
},

                error: function(xhr, status, error) {
                    console.error("Error fetching booked seats:", error);
                }
            });
        }
    });


    // Function for handling seat clicks remains the same
    // Add the event listener for the seat click

    // Function to generate seats for the circle
    function generateOuterSeats(circleId, numSeats, circlePrefix, radius) {
        const circle = document.getElementById(circleId);
        const centerX = circle.clientWidth / 2;
        const centerY = circle.clientHeight / 2;
        const angleStep = (2 * Math.PI) / numSeats;

        for (let i = 0; i < numSeats; i++) {
            const angle = i * angleStep;

            // Skip seat creation for gaps
            if (i === Math.floor(numSeats / 4) || i === Math.floor(3 * numSeats / 4)) {
                continue;
            }

            const x = centerX + radius * Math.cos(angle) - 20;
            const y = centerY + radius * Math.sin(angle) - 20;

            const seat = document.createElement('div');
            seat.classList.add('seat');
            const seatNumber = circlePrefix + (i + 1);
            seat.dataset.seatNumber = seatNumber;
            seat.textContent = seatNumber;

            // Corrected position assignment using template literals
            seat.style.left = `${x}px`;
            seat.style.top = `${y}px`;

            // Mark seat as booked if it's in the bookedSeats array
            if (bookedSeats.includes(seatNumber)) {
                seat.classList.add('booked');
            } else {
                seat.classList.add('available');
            }

            // Add click event for seat selection
            addSeatClickEvent(seat);
            circle.appendChild(seat);
        }
    }

    // Function to generate middle seats
    function generateMiddleSeats(circleId, circlePrefix) {
        const circle = document.getElementById(circleId);
        const centerX = circle.clientWidth / 2;
        const centerY = circle.clientHeight / 2;

        // Create 4 middle seats in a square formation
        for (let i = 0; i < 4; i++) {
            const seat = document.createElement('div');
            seat.classList.add('seat');
            const seatNumber = circlePrefix + (21 + i);
            seat.dataset.seatNumber = seatNumber;
            seat.textContent = seatNumber;

            // Position seats in a square formation
            const offset = 30; // Adjust offset for spacing
            seat.style.left = `${centerX + (i % 2 === 0 ? -offset : offset)}px`; // X position
            seat.style.top = `${centerY + (i < 2 ? -offset : offset)}px`; // Y position

            // Mark seat as booked if it's in the bookedSeats array
            if (bookedSeats.includes(seatNumber)) {
                seat.classList.add('booked');
            } else {
                seat.classList.add('available');
            }

            // Add click event to toggle seat selection
            addSeatClickEvent(seat);
            circle.appendChild(seat);
        }
    }

    // Function to handle seat click events
    function addSeatClickEvent(seat) {
        seat.addEventListener('click', function () {
            if (!seat.classList.contains('booked')) {
                // Unselect previously selected seat
                if (selectedSeat) {
                    selectedSeat.classList.remove('selected');
                }

                // Toggle current seat selection
                seat.classList.add('selected');
                selectedSeat = seat;

                // Update hidden input with the selected seat number as a JSON string
                selectedSeatInput.val(JSON.stringify([seat.dataset.seatNumber]));
            }
        });
    }

    // Generate seats for two circles
    generateOuterSeats('circle1', 20, 'A', 120);
    generateOuterSeats('circle2', 20, 'B', 120);
    generateMiddleSeats('circle1', 'A');
    generateMiddleSeats('circle2', 'B');

    // Confirmation Modal Logic
    $('#confirm-booking').on('click', function() {
        if (!selectedSeat) {
            alert("Please select a seat before booking.");
            return;
        }

        const date = $('#datepicker').val();
        const seatNumber = selectedSeat.dataset.seatNumber;

        // Show confirmation modal
        const confirmation = confirm(`Confirm booking for ${seatNumber} on ${date}?`);
        if (confirmation) {
            $('#booking-form').submit();
        }
    });
});
</script>

@endsection
