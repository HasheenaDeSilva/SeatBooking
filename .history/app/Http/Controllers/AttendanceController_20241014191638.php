<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel; // Include Laravel Excel if using for Excel export
use App\Exports\AttendanceExport; // Create an export class for Excel

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
        ], [
            'attendances.*.intern_name.required' => 'Intern name is required.',
            'attendances.*.intern_id.required' => 'Intern ID is required.',
            'attendances.*.seat_number.required' => 'Seat number is required.',
            'attendances.*.date.required' => 'Date is required.',
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

    public function exportCsv()
    {
        $attendances = AttendanceRecord::all();

        // Prepare CSV headers
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=attendance.csv",
        ];

        // Create a file handle
        $handle = fopen('php://output', 'w');

        // Add column headings
        fputcsv($handle, ['Booking ID', 'Intern Name', 'Intern ID', 'Seat Number', 'Date', 'Is Present']);

        // Add data rows
        foreach ($attendances as $attendance) {
            fputcsv($handle, [
                $attendance->intern_id, // Assuming you want to export intern_id instead of booking_id
                $attendance->intern_name,
                $attendance->seat_number,
                $attendance->date,
                $attendance->is_present ? 'Present' : 'Absent',
            ]);
        }

        fclose($handle);

        return Response::stream(function() use ($handle) {
            fclose($handle);
        }, 200, $headers);
    }

    public function exportExcel()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }
}
