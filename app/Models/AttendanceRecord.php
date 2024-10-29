<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $table = 'attendance_records';

    // Define the fillable properties
    protected $fillable = [
        'intern_name',
        'intern_id',
        'seat_number',
        'date',
        'is_present',
    ];
}