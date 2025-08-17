<?php
session_start();
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$user_email = $_SESSION['email'] ?? '';
if (!$user_email) die("User not logged in.");

$query = "
    SELECT p.*, h.name AS hotel_name
    FROM payments p
    JOIN hotels h ON p.hotel_id = h.hotel_id
    WHERE p.user_email = ?
    ORDER BY p.created_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
$payment_count = $result->num_rows;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease-in-out;
        }
        .card:hover { transform: scale(1.02); }
        .badge-status {
            font-size: 0.9rem;
            padding: 0.4em 0.7em;
            border-radius: 8px;
        }
        .flex-center {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body class="container py-4">
    <h2 class="mb-4 text-center mt-5">Your Payment History</h2>
    
    <?php if ($payment_count > 0): ?>
    <div class="flex-center">
        <?php while ($row = $result->fetch_assoc()): 
            $statusClass = match(strtolower($row['status'])) {
                'paid' => 'success',
                'pending' => 'warning',
                'failed' => 'danger',
                default => 'secondary'
            };
        ?>
            <div class="card p-3" style="width: 300px;">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($row['hotel_name']) ?></h5>
                    <p class="card-text mb-1"><strong>Payer:</strong> <?= htmlspecialchars($row['payer_name']) ?></p>
                    <p class="card-text mb-1"><strong>Amount:</strong> $<?= number_format($row['amount'], 2) ?></p>
                    <p class="card-text mb-1"><strong>Card:</strong> <?= strtoupper($row['card_brand']) ?> ****<?= $row['card_last4'] ?></p>
                    <p class="card-text mb-1"><strong>Date:</strong> <?= $row['created_at'] ?? '-' ?></p><br>
                    <span class="badge bg-<?= $statusClass ?> badge-status"><?= ucfirst($row['status']) ?></span>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <!-- Back to Home button -->
    <div class="text-center mt-5">
        <a href="code.html" class="btn btn-secondary btn-lg">Back to Home</a>
    </div>
    <?php else: ?>
       <div class="text-center mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/954/954591.png" width="140" class="mb-3">
            <h4>No payments found</h4>
            <p class="text-muted">Looks like you haven't made any payments yet.</p>
            <a href="bookHotel.html" class="btn btn-primary mt-3">Book a Hotel</a>
       </div>
    <?php endif; ?>

    

</body>
</html>
