<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attendance_records', function (Blueprint $table) {
            $table->id();
            $table->string('intern_name');  // Column for intern name
            $table->string('intern_id');    // Column for intern ID
            $table->string('seat_number');   // Column for seat number
            $table->date('date');            // Column for the booking date
            $table->boolean('is_present')->default(false); // Column for attendance status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
    }
};