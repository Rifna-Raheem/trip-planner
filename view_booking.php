<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_email = $_SESSION['email'] ?? '';
if (!$user_email) die("User not logged in.");

$query = "
    SELECT b.booking_id,b.checkin, b.checkout, b.num_guests, b.total_price, b.booking_date, b.hotel_id,
           b.booking_status, b.payment_status,
           h.name AS hotel_name, h.location, h.image1
    FROM bookings b
    JOIN hotels h ON b.hotel_id = h.hotel_id
    WHERE b.email = ?
    ORDER BY b.booking_date DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$booking_count = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.02);
        }
        .flex-center {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .hotel-img {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
            width: 100%;
        }
    </style>
</head>
<body class="container py-4">
    <h2 class="mb-5 text-center mt-5">Your Bookings</h2>

    <?php if ($booking_count > 0): ?>
    <div class="flex-center">
        <?php while ($row = $result->fetch_assoc()): 
            $bookingStatus = ucfirst($row['booking_status']);
            $paymentStatus = ucfirst($row['payment_status']);
            $statusColor = match (strtolower($bookingStatus)) {
                'confirmed' => 'success',
                'pending' => 'warning',
                'cancelled' => 'danger',
                default => 'secondary'
            };
            $paymentColor = strtolower($paymentStatus) === 'paid' ? 'success' : 'warning';
        ?>
        <div class="card" style="width: 320px;">
            <img src="img/<?= htmlspecialchars($row['image1']) ?>" class="hotel-img" alt="Hotel Image">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($row['hotel_name']) ?></h5>
                <p class="card-text"><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
                <p class="card-text"><strong>Check-in:</strong> <?= $row['checkin'] ?><br>
                   <strong>Check-out:</strong> <?= $row['checkout'] ?></p>
                <p class="card-text"><strong>Guests:</strong> <?= $row['num_guests'] ?></p>
                <p class="card-text"><strong>Total Price:</strong> $<?= number_format($row['total_price'], 2) ?></p>
                <p class="card-text"><strong>Booking Date:</strong> <?= $row['booking_date'] ?></p>
                <p class="card-text">
                    <strong>Booking Status:</strong>
                    <span class="badge bg-<?= $statusColor ?>"><?= $bookingStatus ?></span>
                </p>
                <p class="card-text">
                    <strong>Payment Status:</strong>
                    <span class="badge bg-<?= $paymentColor ?>"><?= $paymentStatus ?></span>
                </p>

                <!-- Conditional Button Logic -->
<?php 
$bookingId = $row['booking_id'];
$lowerBookingStatus = strtolower($bookingStatus);
$lowerPaymentStatus = strtolower($paymentStatus);
?>

<?php if ($lowerBookingStatus === 'confirmed' && $lowerPaymentStatus === 'pending'): ?>
    <div class="d-flex gap-2 mt-3">
        <a href="payment.php?booking_id=<?= $bookingId ?>&amp;amount=<?= $row['total_price'] ?> &amp;hotel_id=<?= $row['hotel_id'] ?>" class="btn btn-warning">Pay Now</a>
        <a href="cancel_booking.php?booking_id=<?= $bookingId ?>" class="btn btn-danger w-50">Cancel Booking</a>
    </div>

<?php elseif ($lowerBookingStatus === 'confirmed' && $lowerPaymentStatus === 'paid'): ?>
   <a href="cancel_and_refund.php?booking_id=<?= $bookingId ?>" class="btn btn-danger w-100 mt-3">Cancel & Request Refund</a>

<?php elseif ($lowerBookingStatus === 'cancelled'): ?>
    <div class="alert alert-danger text-center mt-3 py-1 mb-0">Booking Cancelled</div>
<?php endif; ?>

            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php else: ?>
        <div class="text-center mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="150" class="mb-3" alt="No Bookings">
            <h4>No bookings found</h4>
            <p class="text-muted">Looks like you haven't booked any hotels yet.</p>
            <a href="bookHotel.html" class="btn btn-primary mt-3">Book a Hotel</a>
        </div>
    <?php endif; ?>
</body>
</html>
