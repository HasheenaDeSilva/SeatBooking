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
use App\Http\Controllers\InternController;
use App\Http\Controllers\LogoutController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::post('/selection', [HomeController::class, 'handleSelection'])->name('selection.handle');

Route::get('/welcome/intern', function () {
    return view('welcome-intern');
})->name('welcome.intern');

Route::get('/welcome/admin', function () {
    return view('welcome-admin');
})->name('welcome.admin');


Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

Route::get('/intern/login', [InternAuthController::class, 'showLoginForm'])->name('intern.login');
Route::post('/intern/login', [InternAuthController::class, 'login']);
Route::get('/intern/register', [InternAuthController::class, 'showRegisterForm'])->name('intern.register');
Route::post('/intern/register', [InternAuthController::class, 'register']);




Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');



Route::get('/pages/intern/booking', [BookingController::class, 'showBookingPage'])->name('intern.booking');
Route::post('/pages/intern/booking', [BookingController::class, 'store'])->name('intern.booking.store');
// Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('pages.admin.login');

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
// Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Facebook Routes
Route::get('auth/facebook', [SocialAuthController::class, 'facebookpage']);;
Route::get('auth/facebook/callback', [SocialAuthController::class, 'facebookredirect']);;

// Google Routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

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
Route::get('/attendance/filter', [BookingController::class, 'filterBookings'])->name('attendance.filter');use App\Http\Controllers\Auth\PasswordResetController;

Route::get('password/reset', [PasswordResetController::class, 'showResetRequestForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
// Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');Route::get('/test-email', function () {
//     \Mail::raw('This is a test email.', function ($message) {
//         $message->to('hasheenadesilva@gmail.com') // replace with your recipient email
//                 ->subject('Test Email');
//     });

//     return 'Email sent!';
// // });Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.request');
// Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/update', [PasswordResetController::class, 'reset'])->name('password.update');
// Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');use App\Http\Controllers\InternController;

Route::post('/get-booked-seats', [BookingController::class, 'getBookedSeats'])->name('get.booked.seats');

Route::get('/pages/intern/bookingnew', [BookingController::class, 'showBookingNewPage'])->name('intern.bookingnew');