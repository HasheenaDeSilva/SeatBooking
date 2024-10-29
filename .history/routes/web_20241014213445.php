<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InternAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AttendanceController;
use App\Models\AttendanceRecord;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SocialAuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/selection', [HomeController::class, 'handleSelection'])->name('selection.handle');

Route::get('/welcome/intern', function () {
    return view('welcome-intern');
})->name('welcome.intern');

Route::get('/welcome/admin', function () {
    return view('welcome-admin');
})->name('welcome.admin');

Route::get('/pages/intern/register', [InternAuthController::class, 'showRegisterForm'])->name('intern.register');
Route::post('/pages/intern/register', [InternAuthController::class, 'register']);
Route::get('/pages/intern/login', [InternAuthController::class, 'showLoginForm'])->name('pages.intern.login');
Route::post('/pages/intern/login', [InternAuthController::class, 'intern.login']);

Route::get('/pages/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/pages/admin/register', [AdminAuthController::class, 'register']);
Route::get('/pages/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/pages/admin/login', [AdminAuthController::class, 'login']);


Route::get('/pages/intern/booking', [BookingController::class, 'showBookingPage'])->name('intern.booking');
Route::post('/pages/intern/booking', [BookingController::class, 'store'])->name('intern.booking.store');
// Add middleware for authentication
Route::get('/login', [InternAuthController::class, 'showLoginForm'])->name('login');
Route::get('/pages/booking/view', [BookingController::class, 'index'])->name('booking.view');

Route::get('/pages/admin/view', [BookingController::class, 'showBookings'])->name('admin.view');

Route::resource('bookings', BookingController::class);
Route::get('/pages/booking/view/{id}/receipt', [BookingController::class, 'downloadReceipt'])->name('booking.receipt');

Route::post('/attendance/save', [AttendanceController::class, 'saveAttendance'])->name('attendance.save');
// Route::get('/booking', [BookingController::class, 'create'])->name('pages.intern.booking');
// Route::post('/booking', [BookingController::class, 'store']);
// Route::get('/bookings', [BookingController::class, 'index'])->name('intern.bookings');
// Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
// Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('booking.edit');
// Route::put('/booking/update/{id}', [BookingController::class, 'update'])->name('booking.update');

// Add these routes for password reset functionality
Route::get('password/request', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Facebook Routes
Route::get('auth/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('auth/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);

// Google Routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

 // For form submission

// Login Route for InternsRoute::get('attendance/download', function () {
    Route::get('attendance/download', function () {
    $attendanceRecords = AttendanceRecord::all();

    $filename = "attendance_records.txt";
    $headers = [
        "Content-type" => "text/plain",
        "Content-Disposition" => "attachment; filename=$filename",
    ];

    // Set the column widths
    $idWidth = 5;
    $nameWidth = 20;
    $internIdWidth = 10;
    $seatWidth = 15;
    $dateWidth = 12;
    $presentWidth = 10;

    $output = str_pad("ID", $idWidth) .
              str_pad("Intern Name", $nameWidth) .
              str_pad("Intern ID", $internIdWidth) .
              str_pad("Seat Number", $seatWidth) .
              str_pad("Date", $dateWidth) .
              str_pad("Is Present", $presentWidth) . "\n";

    foreach ($attendanceRecords as $record) {
        $output .= str_pad($record->id, $idWidth) .
                   str_pad($record->intern_name, $nameWidth) .
                   str_pad($record->intern_id, $internIdWidth) .
                   str_pad($record->seat_number, $seatWidth) .
                   str_pad($record->date, $dateWidth) .
                   str_pad($record->is_present ? 'Yes' : 'No', $presentWidth) . "\n";
    }

    return response($output, 200, $headers);
})->name('attendance.download');