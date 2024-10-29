<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'seat_number', 'intern_id', 'intern_name'];

    // If seat_number is stored as JSON, cast it as an array
    // protected $casts = [
    //     'seat_number' => 'array',
    // ];
}
