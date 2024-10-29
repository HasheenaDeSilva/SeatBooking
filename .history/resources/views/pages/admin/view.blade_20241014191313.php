@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center my-4">All Bookings</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <!-- Search Bar -->
    <div class="mb-3 text-center">
        <input type="text" id="search" class="form-control w-50 mx-auto" placeholder="Search by Intern Name or ID..." onkeyup="filterBookings()">
    </div>

    <!-- Export Buttons -->
    <div class="mb-3 text-center">
        <a href="{{ route('attendance.export.csv') }}" class="btn btn-warning">Export as CSV</a>
        <a href="{{ route('attendance.export.excel') }}" class="btn btn-warning">Export as Excel</a>
    </div>

    <form action="{{ route('attendance.save') }}" method="POST" id="attendance-form">
        @csrf
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center" id="bookingsTable">
                <thead class="thead-light">
                    <tr>
                        <th><a href="#" onclick="sortTable(0)">Booking ID</a></th>
                        <th><a href="#" onclick="sortTable(1)">Intern Name</a></th>
                        <th><a href="#" onclick="sortTable(2)">Intern ID</a></th>
                        <th><a href="#" onclick="sortTable(3)">Seat Number</a></th>
                        <th><a href="#" onclick="sortTable(4)">Booking Date</a></th>
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
            <button type="submit" class="btn btn-success mt-3" onclick="return confirm('Are you sure you want to save attendance?');">Save Attendance</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('attendance.download') }}" class="btn btn-primary">Download Attendance Records</a>
    </div>
</div>

<script>
function filterBookings() {
    let input = document.getElementById('search');
    let filter = input.value.toLowerCase();
    let table = document.getElementById('bookingsTable');
    let tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let td = tr[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                if (td[j].innerHTML.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        tr[i].style.display = found ? '' : 'none';
    }
}

// Sorting Function
function sortTable(columnIndex) {
    let table = document.getElementById('bookingsTable');
    let rows = Array.from(table.rows).slice(1); // Exclude header
    let sortedRows = rows.sort((a, b) => {
        let aText = a.cells[columnIndex].textContent.trim();
        let bText = b.cells[columnIndex].textContent.trim();
        
        return aText.localeCompare(bText, undefined, { numeric: true });
    });
    
    // Append sorted rows to the table
    sortedRows.forEach(row => table.appendChild(row));
}
</script>

@endsection
