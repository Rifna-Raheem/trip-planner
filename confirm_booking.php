<?php
session_start(); 
// DB Connection
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$email=$_SESSION['email'];
$hotel_id = isset($_POST['hotel_id']) ? (int)$_POST['hotel_id'] : 0;
$checkin = isset($_POST['checkin']) ? $_POST['checkin'] : '';
$checkout = isset($_POST['checkout']) ? $_POST['checkout'] : '';
$num_guests = isset($_POST['num_guests']) ? (int)$_POST['num_guests'] : 1;
$total_price = isset($_POST['total_price']) ? (float)$_POST['total_price'] : 0.0;

$booking_id = 0; // initialize


// Basic validation
if ($hotel_id > 0 && $checkin && $checkout && $num_guests > 0 && $total_price >= 0) {

    // Insert into bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (hotel_id, email, checkin, checkout, num_guests, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssid", $hotel_id, $email, $checkin, $checkout, $num_guests, $total_price);

    if ($stmt->execute()) {
        $booking_id = $conn->insert_id; // Get the inserted booking ID
        $message = "✅ Booking confirmed successfully!";
    } else {
        $message = "❌ Booking failed: " . $stmt->error;
    }

    $stmt->close();
} else {
    $message = "❗ Invalid booking data submitted.";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .confirmation-box {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            text-align: center;
            margin-top:200px;
        }
        .confirmation-box h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="confirmation-box">
    <h2>Booking Status</h2>
    <p><?php echo $message; ?></p>
   
     <?php if ($booking_id > 0): ?>
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="payment.php?booking_id=<?= $booking_id ?>&hotel_id=<?= $hotel_id ?>&amount=<?= $total_price ?>" class="btn btn-primary">
            Proceed to Payment
        </a>
        <a href="code.html" class="btn btn-secondary">
            Back to Home
        </a>

 <?php endif; ?>

</div>

</body>
</html>
