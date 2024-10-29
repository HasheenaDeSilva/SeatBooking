<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Booking; // Make sure you import the Booking model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AttendanceRecord;



// Correct import for the PDF facade



class BookingController extends Controller
{
    // Show the booking form
//    public function create()
// {
//     // Fetch session variables
//     $intern_name = session('intern_name');
//     $intern_id = session('intern_id');

//     // Check if the variables are set
//     if (!$intern_name || !$intern_id) {
//         // Use the named route for redirection
//         return redirect()->route('pages.intern.login')->withErrors(['login_error' => 'You must be logged in to access this page.']);
//     }

//     // Return the view with the necessary variables
//     return view('pages.intern.booking', [
//         'intern_name' => $intern_name,
//         'intern_id' => $intern_id,
//     ]);
// }

   public function create()
{
    // Ensure $intern_id is defined, e.g.:
    $intern_id = session('intern_id');
    $intern_name = session('intern_name');

        \Log::info('Session values in create method:', [
            'intern_id' => $intern_id,
            'intern_name' => $intern_name,
        ]);

        if (!$intern_id || !$intern_name) {
            return redirect()->route('login')->withErrors(['message' => 'You must be logged in to access this page.']);
        }// Or retrieve it from the database or a model

    // Pass the $intern_id to the view
    return view('pages.intern.booking', compact('intern_id', 'intern_name'));
}

    // public function store(Request $request)
    // {
    //     // Validate incoming request data
    //     $request->validate([
    //         'booking_date' => 'required|date',
    //         'trainee_id' => 'required',
    //         'selected_seats' => 'required|json',  // Validate selected seats as JSON
    //     ]);

    //     $intern = Intern::findOrFail($request->input('trainee_id')); // Ensure we find the intern

    //     // Decode the JSON into an array
    //     $selectedSeats = json_decode($request->input('selected_seats'), true);

    //     // Ensure selectedSeats is an array and assign the first seat as seat_number
    //     $seatNumber = isset($selectedSeats[0]) ? $selectedSeats[0] : null;

    //     // If no seat number is available, return an error
    //     if (is_null($seatNumber)) {
    //         return back()->withErrors(['selected_seats' => 'Please select a valid seat.']);
    //     }

    //     // Create a new Booking instance
    //     $booking = new Booking();
    //     $booking->booking_date = $request->input('booking_date');
    //     $booking->trainee_id = $request->input('trainee_id');
    //     $booking->seat_number = $seatNumber;  // Assign the correct seat number from selectedSeats array
    //     $booking->selected_seats = json_encode($selectedSeats); // Save selected seats as JSON
    //     $booking->name = $intern->name;
    //     $booking->count = count($selectedSeats); // Save the count of selected seats
    //     $booking->save(); // Save the booking to the database

    //     // Redirect to bookings with a success message
    //     return redirect()->route('intern.bookings')->with('success', 'Seat booked successfully!');
    // }

    public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'intern_id' => 'required|exists:interns,intern_id',
        'date' => 'required|date',
        'seat_number' => 'required|string', // Ensure seat_number is a valid string
    ]);

    // Check if the intern exists in the database
    $intern = DB::table('interns')->where('intern_id', $request->intern_id)->first();

    if (!$intern) {
        return back()->withErrors(['intern_id' => 'The selected intern does not exist.']);
    }

    // Check if the seat is already booked
    $seatAlreadyBooked = Booking::where('date', $request->date)
        ->where('seat_number', $request->seat_number) // Check seat_number directly
        ->exists();

    if ($seatAlreadyBooked) {
        return back()->withErrors(['seat_number' => 'This seat is already booked for the selected date.']);
    }

    // Create the booking, including the intern_id and seat_number
    Booking::create([
        'intern_id' => $request->intern_id,
        'date' => $request->date,
        'seat_number' => $request->seat_number, // Use seat_number directly
    ]);

    return redirect()->route('booking.view')->with('success', 'Booking created successfully.');
}


    // Display bookings for the authenticated intern
    // public function index()
    // {
    //     // Fetch bookings for the authenticated user, along with the associated intern data
    //     $bookings = Booking::with('intern') // Eager load the intern relationship
    //         ->where('trainee_id', Auth::id())
    //         ->get();

    //     return view('booking.index1', compact('bookings'));
    // }

    public function index()
    {


        // Check if the user is authenticated

        // Fetch only bookings related to the logged-in intern
        $internId = session('intern_id');

        if (!$internId) {
            return redirect()->route('login')->with('error', 'You need to be logged in to view your bookings.');
        }

        // Fetch only bookings related to the logged-in intern
        $bookings = Booking::where('intern_id', $internId)->get();
        return view('pages.booking.view', compact('bookings'));

    }


    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking deleted successfully.');
    }

    public function downloadReceipt($id)
    {
        $booking = Booking::findOrFail($id); // Retrieve the booking

        $receiptContent = "Receipt\n";
        $receiptContent .= "Booking ID: " . $booking->id . "\n";
        $receiptContent .= "Intern Name: " . $booking->intern_name . "\n";
        $receiptContent .= "Intern ID: " . $booking->intern_id . "\n";
        $receiptContent .= "Date: " . $booking->date . "\n";
        $receiptContent .= "Seat Number: " . $booking->seat_number . "\n";
        // Add more details as needed

        return response($receiptContent)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="receipt_' . $booking->id . '.txt"');
    }

    // Show edit form
    // public function edit($id)
    // {
    //     $booking = Booking::findOrFail($id);
    //     return view('bookings.edit1', compact('booking'));
    // }

    // Update booking
    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'booking_date' => 'required|date'
    //     ]);

    //     $booking = Booking::findOrFail($id);
    //     $booking->update([
    //         'booking_date' => $validatedData['booking_date']
    //     ]);

    //     return redirect()->route('intern.bookings')->with('success', 'Booking updated successfully');
    // }


   public function showBookingPage(Request $request)
    {
        $intern_id = $request->input('intern_id');
        $intern_name = $request->input('intern_name');

        return view('pages.intern.booking', compact('intern_id', 'intern_name'));
    }

    public function showBookings()
    {
        $bookings = Booking::all();
        $attendanceRecords = AttendanceRecord::all(); // Fetch all bookings
        return view('pages.admin.view', compact('bookings'));
    }

}