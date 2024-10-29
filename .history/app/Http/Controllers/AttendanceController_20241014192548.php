<?php

namespace App\Http\Controllers;
use App\Models\AttendanceRecord;
use App\Models\Booking;

use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function saveAttendance(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'attendances.*.intern_name' => 'required|string|max:255',
            'attendances.*.intern_id' => 'required|string|max:255',
            'attendances.*.seat_number' => 'required|string|max:255',
            'attendances.*.date' => 'required|date',
            'attendances.*.is_present' => 'boolean',
        ]);

        // Iterate through each attendance entry
        foreach ($request->attendances as $attendance) {
            // Create a new attendance record
            AttendanceRecord::updateOrCreate(
                [
                    'intern_id' => $attendance['intern_id'], // Unique identifier for the intern
                    'date' => $attendance['date'], // Date for attendance
                ],
                [
                    'intern_name' => $attendance['intern_name'],
                    'seat_number' => $attendance['seat_number'],
                    'is_present' => isset($attendance['is_present']) ? 1 : 0, // Set present status
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }

}