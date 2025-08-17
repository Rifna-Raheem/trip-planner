<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Successful</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }
    .success-box {
      background: #fff;
      color: #333;
      padding: 30px 40px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.2);
      text-align: center;
    }
    .success-box h2 {
      color: green;
      font-weight: 600;
    }
    .btn-custom {
      margin-top: 10px;
      min-width: 150px;
    }
    .btn-group-custom {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <h2>✅ Payment Successful!</h2>
    <p>Thank you for your payment. Your transaction has been completed.</p>
    <div class="btn-group-custom">
      <a href="view_payment.php" class="btn btn-success btn-custom">View Payment Details</a>
      <a href="code.html" class="btn btn-primary btn-custom">Home</a>
    </div>
  </div>
</body>
</html>
