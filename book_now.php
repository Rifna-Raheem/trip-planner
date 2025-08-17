<?php
session_start(); 

$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$hotel_id = isset($_GET['hotel_id']) ? $_GET['hotel_id'] : 0;
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$guests = isset($_GET['num_guests']) ? (int)$_GET['num_guests'] : 1;

// Get hotel details
$sql = "SELECT * FROM hotels WHERE hotel_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $hotel_id);
$stmt->execute();
$result = $stmt->get_result();
$hotel = $result->fetch_assoc();

$is_available = true;
$message = "";

// Check if same user already booked same hotel for same dates
$check_sql = "SELECT * FROM bookings WHERE email = ? AND hotel_id = ? AND checkin = ? AND checkout = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("siss", $email, $hotel_id, $checkin, $checkout);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $is_available = false;
    $booking = $check_result->fetch_assoc();
    $booking_id = $booking['booking_id'];
    $total_price = $booking['total_price'];
    $payment_status = strtolower($booking['payment_status']);

    $message = '
    <div class="alert alert-info p-4 ">
        <h5 class="mb-3">You already booked this hotel for the selected dates.</h5>
        <div class="d-flex flex-wrap gap-3">
            <a href="view_booking.php" class="btn btn-success">View Booking</a>';

    if ($payment_status !== 'paid') {
        $message .= '
            <a href="payment.php?booking_id=' . $booking_id . '&hotel_id=' . $hotel_id . '&amount=' . $total_price . '" class="btn btn-primary">Proceed to Payment</a>';
    } else {
        $message .= '
            <a href="search_hotels.php?destination=' . urlencode($hotel['location']) . '&checkin=' . urlencode($checkin) . '&checkout=' . urlencode($checkout) . '&num_guests=' . urlencode($guests) . '" class="btn btn-primary">Add New Booking</a>';
    }

    $message .= '
        </div>
    </div>';
} else {
    // Check if same user booked same hotel for different dates
    $check_diff_sql = "SELECT * FROM bookings WHERE email = ? AND hotel_id = ? AND (checkin != ? OR checkout != ?)";
    $check_diff_stmt = $conn->prepare($check_diff_sql);
    $check_diff_stmt->bind_param("siss", $email, $hotel_id, $checkin, $checkout);
    $check_diff_stmt->execute();
    $check_diff_result = $check_diff_stmt->get_result();

    if ($check_diff_result->num_rows > 0) {
        $booking = $check_diff_result->fetch_assoc();
        $booking_id = $booking['booking_id'];
        $total_price = $booking['total_price'];
        $payment_status = strtolower($booking['payment_status']);

        $message = '
        <div class="alert alert-primary p-4">
            <h5 class="mb-3">You already booked this hotel for different dates.</h5>
            <div class="d-flex flex-wrap gap-3">
                <a href="view_booking.php" class="btn btn-success">View Booking</a>';

        if ($payment_status !== 'paid') {
            $message .= '
                <a href="payment.php?booking_id=' . $booking_id . '&hotel_id=' . $hotel_id . '&amount=' . $total_price . '" class="btn btn-primary">Proceed to Payment</a>';
        } else {
            $message .= '
                <a href="search_hotels.php?destination=' . urlencode($hotel['location']) . '&checkin=' . urlencode($checkin) . '&checkout=' . urlencode($checkout) . '&num_guests=' . urlencode($guests) . '" class="btn btn-primary">Add New Booking</a>';
        }

        $message .= '
            </div>
        </div>';

        $is_available = false;
    }
}

// If not already booked, check availability
if ($hotel && $checkin && $checkout && $is_available) {
    $availability_sql = "SELECT * FROM bookings 
                         WHERE hotel_id = ? 
                         AND (
                             (checkin <= ? AND checkout > ?) OR
                             (checkin < ? AND checkout >= ?) OR
                             (checkin >= ? AND checkout <= ?)
                         )";

    $availability_stmt = $conn->prepare($availability_sql);
    $availability_stmt->bind_param("issssss", $hotel_id, $checkout, $checkin, $checkout, $checkin, $checkin, $checkout);
    $availability_stmt->execute();
    $availability_result = $availability_stmt->get_result();

    if ($availability_result->num_rows > 0) {
        $is_available = false;
         $message = "<div class='alert alert-danger'>Sorry, this hotel is not available for the selected dates.</div>";
    }

    $availability_stmt->close();
}

// Calculate number of nights
$nights = 0;
if ($checkin && $checkout) {
    $start = new DateTime($checkin);
    $end = new DateTime($checkout);
    $interval = $start->diff($end);
    $nights = $interval->days;
}

// Set base guest limit and extra fee per guest per night
$base_guests = 2;
$extra_guest_fee_per_night = 100;

// Calculate extra guests and fee
$extra_guests = max(0, $guests - $base_guests);
$extra_fee = $extra_guests * $extra_guest_fee_per_night * $nights;

// Total price
$price_per_night = $hotel['price_per_night'];
$total_price = ($price_per_night * $nights) + $extra_fee;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Booking Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }
    .booking-wrapper {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding-top: 100px;
    }
    .booking-card {
      background: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 400px;
      width: 100%;
    }
    .info-label {
      font-weight: 600;
      color: #333;
    }
    .btn-confirm {
      padding: 10px 30px;
      font-size: 16px;
    }
  </style>
</head>
<body>

<div class="container booking-wrapper">
  <?php if ($hotel): ?>
    <?php if ($is_available): ?>
    <div class="booking-card">
      <h2 class="mb-4 text-primary"><?php echo htmlspecialchars($hotel['name']); ?></h2>
      <p><span class="info-label">Location:</span> <?php echo htmlspecialchars($hotel['location']); ?></p>
      <p><span class="info-label">Check-in:</span> <?php echo htmlspecialchars($checkin); ?></p>
      <p><span class="info-label">Check-out:</span> <?php echo htmlspecialchars($checkout); ?></p>
      <p><span class="info-label">Guests:</span> <?php echo $guests; ?> (<?php echo $extra_guests > 0 ? "$extra_guests extra guest(s)" : "no extra guests"; ?>)</p>
      <p><span class="info-label">Price per night:</span> $<?php echo $price_per_night; ?></p>
      <p><span class="info-label">Total nights:</span> <?php echo $nights; ?></p>
      <p><span class="info-label">Extra fee:</span> $<?php echo $extra_fee; ?></p>
      <h4 class="mt-3"><strong>Total Price:</strong> $<?php echo $total_price; ?></h4>

      <form action="confirm_booking.php" method="POST" class="mt-4 ">
        <input type="hidden" name="hotel_id" value="<?php echo $hotel['hotel_id']; ?>">
        <input type="hidden" name="checkin" value="<?php echo $checkin; ?>">
        <input type="hidden" name="checkout" value="<?php echo $checkout; ?>">
        <input type="hidden" name="num_guests" value="<?php echo $guests; ?>">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <button type="submit" class="btn btn-success btn-confirm">Confirm Booking</button>
      </form>
    </div>
    <?php else: ?>
      <?php echo $message; ?>
    <?php endif; ?>
  <?php else: ?>
    <div class="alert alert-danger">Hotel not found.</div>
  <?php endif; ?>
</div>

</body>
</html>

<?php
$stmt->close();
$check_stmt->close();
$conn->close();
?>
