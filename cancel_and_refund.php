<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) die("Connection failed.");

// 1. Get the booking ID from the URL
$booking_id = $_GET['booking_id'] ?? '';
if (!$booking_id) die("No booking ID.");

// 2. First, update the bookings table
$stmt1 = $conn->prepare("
    UPDATE bookings 
    SET booking_status = 'cancelled', payment_status = 'Refund_requested' 
    WHERE booking_id = ? AND payment_status = 'paid'
");
$stmt1->bind_param("i", $booking_id);
$stmt1->execute();

// 3. If bookings table was updated, update the payments table
if ($stmt1->affected_rows > 0) {
    $stmt2 = $conn->prepare("
        UPDATE payments 
        SET status = 'refund requested' 
        WHERE booking_id = ?
    ");
    $stmt2->bind_param("i", $booking_id);
    $stmt2->execute();

    echo "<script>alert('Booking cancelled. Refund request submitted.'); window.location.href='view_booking.php';</script>";
} else {
    echo "<script>alert('Cannot cancel this booking.'); window.location.href='view_booking.php';</script>";
}
?>
