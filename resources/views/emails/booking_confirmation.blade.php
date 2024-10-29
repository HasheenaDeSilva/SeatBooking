<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Booking Confirmation</h1>
    <p>Dear {{ $internName }},</p>
    <p>Your seat has been successfully booked!</p>
    <p><strong>Seat Number:</strong> {{ $seatNumber }}</p>
    <p><strong>Booking Date:</strong> {{ $bookingDate }}</p>
    <p>Thank you for booking with us!</p>
</body>
</html>
