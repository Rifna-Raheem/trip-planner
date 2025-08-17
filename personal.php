<?php
session_start();
include 'db.php';

if (!isset($_SESSION['email'])) {
    die("You must be logged in to access this page.");
}

$email = $_SESSION['email'];

// Check if record exists
$check = $conn->prepare("SELECT id FROM personal_details WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check_result = $check->get_result();
$already_exists = $check_result->num_rows > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Personal Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="code_style.css">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
  <style>
    .top-bar {
      background-color:hsl(205, 100%, 23%); 
      color: white;
      padding: 5px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .main-content {
      background: linear-gradient(rgba(127, 195, 244, 0.8), rgba(13, 27, 81, 0.8));
      min-height: 100vh;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
    } 
    .form-box {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      width: 100%;
      color: #333;
    }
    .form-box h2 {
      text-align: center;
      color: #4CAF50;
      margin-bottom: 20px;
      font-family: "Playfair Display", serif;
    }
    .form-box input, .form-box select, .form-box textarea {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .form-box button {
      background-color: #4CAF50;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      margin-top: 15px;
    }
    .form-box button:hover {
      background-color: #45a049;
    }
    .travel-interest {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 5px;
    }
    .travel-interest label {
      display: flex;
      align-items: center;
      gap: 5px;
    }
  </style>
</head>
<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <div class="top-bar">
    <h1 class="dashboard-title"><b>DASHBOARD</b></h1>
    <a href="About.html"><img src="https://logos-world.net/wp-content/uploads/2023/06/Journey-Emblem.png" alt="Logo"></a>
  </div>

  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-3 col-lg-2 d-md-block sidebar" style="background-color:hsl(205, 100%, 23%);">
        <div class="position-sticky">
          <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link" href="personal.php"><i class="bi bi-person-plus"></i>Add Personal Details</a></li>
            <li class="nav-item"><a class="nav-link" href="view_personal.php"><i class="bi bi-person-circle"></i>View Personal Details</a></li>
            <li class="nav-item"><a class="nav-link" href="trip_scheduler.html"><i class="bi bi-calendar-check"></i>Trip Scheduler</a></li>
            <li class="nav-item"><a class="nav-link" href="bookHotel.html"><i class="bi bi-house-door-fill"></i>Book Hotels</a></li>
            <li class="nav-item"><a class="nav-link" href="view_booking.php"><i class="bi bi-house"></i>View Booked Hotel</a></li>
            <li class="nav-item"><a class="nav-link" href="view_payment.php"><i class="bi bi-cash"></i>Payment</a></li>
            <li class="nav-item"><a class="nav-link" href="About.html"><i class="bi bi-info-circle"></i>About</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i>Log out</a></li>
          </ul>
        </div>
      </nav>

      <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
  <div class="form-box" style="max-width: 600px; padding: 25px;">
    <?php if ($already_exists): ?>
      <h2>You have already provided your personal details</h2>
      <p class="text-muted text-center">If you want, you can view or edit your details below.</p>
      <div class="d-flex justify-content-center">
        <a href="view_personal.php" class="btn btn-primary m-2">View Details</a>
        <a href="edit_personal.php" class="btn btn-warning m-2">Edit Details</a>
      </div>
    <?php else: ?>
      <h2>Add Your Personal Details</h2>
      <form method="POST" action="add_personal.php">
        <label for="name">Full Name:</label>
        <input type="text" name="name" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" max="<?= date('Y-m-d') ?>" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>

        <label for="travel-style">Preferred Travel Style:</label>
        <select name="travel_style" required>
          <option value="">Select</option>
          <option value="Luxury">Luxury</option>
          <option value="Budget">Budget</option>
          <option value="Adventure">Adventure</option>
          <option value="Relaxation">Relaxation</option>
          <option value="Cultural">Cultural</option>
        </select>

        <label for="address">Address:</label>
        <textarea name="address" rows="2"></textarea>

        <label>Travel Interests (optional):</label>
        <div class="travel-interest">
          <label><input type="checkbox" name="travel_interests[]" value="nature"> Nature</label>
          <label><input type="checkbox" name="travel_interests[]" value="history"> History</label>
          <label><input type="checkbox" name="travel_interests[]" value="wildlife"> Wildlife</label>
          <label><input type="checkbox" name="travel_interests[]" value="beaches"> Beaches</label>
          <label><input type="checkbox" name="travel_interests[]" value="food"> Food</label>
          <label><input type="checkbox" name="travel_interests[]" value="shopping"> Shopping</label>
        </div>

        <button type="submit">Submit</button>
      </form>
    <?php endif; ?>
  </div>
</main>

    </div>
  </div>
</body>
</html>
