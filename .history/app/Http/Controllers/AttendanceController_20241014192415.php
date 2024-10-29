<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel; // Include Laravel Excel for Excel export
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
        ]);

        // Iterate through each attendance entry
        foreach ($request->attendances as $attendance) {
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
        fputcsv($handle, ['Intern ID', 'Intern Name', 'Seat Number', 'Date', 'Is Present']);

        // Add data rows
        foreach ($attendances as $attendance) {
            fputcsv($handle, [
                $attendance->intern_id,
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

    public function exportCSV()
    {
        return Excel::download(new AttendanceExport, 'attendance_records.csv');
    }
    
    public function exportExcel()
    {
        return Excel::download(new AttendanceExport, 'attendance_records.xlsx');
    }
    
}