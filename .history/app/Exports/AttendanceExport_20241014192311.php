<?php

namespace App\AttendanceExpert; 

use App\Models\AttendanceRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendanceExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        // Fetch attendance records
        return AttendanceRecord::all();
    }

    public function headings(): array
    {
        return [
            'Intern ID',
            'Intern Name',
            'Seat Number',
            'Date',
            'Is Present',
        ];
    }
}
