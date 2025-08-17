<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) die("Connection failed.");

$booking_id = $_GET['booking_id'] ?? '';
if (!$booking_id) die("No booking ID.");

$stmt = $conn->prepare("UPDATE bookings SET booking_status = 'cancelled', payment_status = 'not required' WHERE booking_id = ? ");
$stmt->bind_param("i", $booking_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Booking cancelled.'); window.location.href='view_booking.php';</script>";
} else {
    echo "<script>alert('Cannot cancel this booking.'); window.location.href='view_booking.php';</script>";
}
?>
