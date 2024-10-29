@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-center mt-5">BOOK YOUR SEAT</h1>

        <!-- Display Intern Details -->
       <p>Welcome, {{ session('intern_name') }} (ID: {{ session('intern_id') }})</p>

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
            <form action="{{ route('intern.booking.store') }}" method="POST">
            @csrf

           <div class="form-group">
    <label for="date" class="font-weight-bold">Select Booking Date:</label>
    <input type="date" id="date" name="date" class="form-control mx-auto" style="width: 200px;" required>
</div>


            <!-- Hidden input for trainee ID -->
            <input type="hidden" id="intern_id" name="intern_id" value="{{ session('intern_id') }}">

            <input type="hidden" id="intern_name" name="intern_name" value="{{ session('intern_name') }}">


            <!-- Circle seating layout -->
            <div class="row justify-content-center mt-4">
                <div class="col-auto">
                    <div class="circle" id="circle1"></div>
                </div>
                <div class="col-auto">
                    <div class="circle" id="circle2"></div>
                </div>
            </div>

            <!-- Hidden input for selected seats -->
        <input type="hidden" id="seat_number" name="seat_number" value="[]">


            <!-- Submit button -->
            <button type="submit" class="btn btn-primary mt-4">Book Seat</button>

            <a href="{{ route('booking.view') }}" class="btn btn-primary">Go to Intern bookings View</a>

        </form>

        <!-- Link to view bookings -->
        {{-- <a href="{{ route('intern.bookings') }}" class="btn btn-info mt-4">View My Bookings</a> --}}
    </div>

    <!-- Custom CSS -->
    <style>
        .circle {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            border: 2px solid #000;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px;
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
        }

        .seat.selected {
            background-color: #4CAF50;
        }

        .seat.booked {
            background-color: red;
            cursor: not-allowed;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>

    <!-- JavaScript to handle seat selection -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
            const selectedSeatsInput = document.getElementById('seat_number');
            const selectedSeats = [];

            // Update the selected_seats field
           function updateSelectedSeats() {
    selectedSeatsInput.value = JSON.stringify(selectedSeats);  // Convert array to JSON string
}


            // Generate seats for the circle
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
                    seat.dataset.seatNumber = circlePrefix + (i + 1);
                    seat.textContent = circlePrefix + (i + 1);

                    seat.style.left = `${x}px`;
                    seat.style.top = `${y}px`;

                    // Add click event to toggle seat selection
                seat.addEventListener('click', function () {
    if (!seat.classList.contains('booked')) {
        seat.classList.toggle('selected');
        const seatNumber = seat.dataset.seatNumber;

        if (seat.classList.contains('selected')) {
            selectedSeats.push(seatNumber);
        } else {
            const index = selectedSeats.indexOf(seatNumber);
            if (index > -1) {
                selectedSeats.splice(index, 1);
            }
        }

        updateSelectedSeats();  // Update the hidden input field
    }
});

                    circle.appendChild(seat);
                }
            }

            // Generate seats for two circles
            generateOuterSeats('circle1', 20, 'A', 120);
            generateOuterSeats('circle2', 20, 'B', 120);
        });
</script>

    </script>
@endsection
