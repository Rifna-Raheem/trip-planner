
<?php
session_start();
include 'db.php';

$email = $_SESSION['email'] ?? null;

$sql = "SELECT name, dob, gender, travel_style, address, travel_interests FROM personal_details WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet"> <!--link for boostrap icons-->
    <link rel="stylesheet" href="code_style.css">
    <!--to use the google font design -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

  <title>Edit Personal Details</title>

  <style> 
  /* Styles for the top dashboard bar */
    .top-bar {
      background-color:hsl(205, 100%, 23%); 
      color: rgb(255, 255, 255);
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

    .form-box input, .form-box select {
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     <!-- Top Bar -->
     <div class="top-bar ">
         

        <!-- Dashboard Title -->
        <h1 class="dashboard-title"><b>DASHBOARD</b></h1>

<!-- Dashboard Logo or Image -->
<a href="About.html"><img src="https://logos-world.net/wp-content/uploads/2023/06/Journey-Emblem.png" alt="Logo"></a>
        
    </div>
    
<!--side bar and main content-->
    <div class="container-fluid">
        <div class="row">
            <!--side bar-->
            <nav class="col-md-3 col-lg-2  d-md-block  sidebar" style="background-color:hsl(205, 100%, 23%);">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        
                        <li class="nav-item">
                            <a class="nav-link" href="personal.php"><i class="bi bi-person-plus"></i>Add Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_personal.php"> <i class="bi bi-person-circle"></i>View Personal Details</a>
                        </li>
                        <li class="nav-item"></li>
                            <a class="nav-link" href="trip_scheduler.html"><i class="bi bi-calendar-check"></i>Trip Scheduler</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="bookHotel.html"><i class="bi bi-house-door-fill"></i>Book Hotels</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_booking.php"><i class="bi bi-house"></i>View Booked Hotel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_payment.php"><i class="bi bi-cash"></i>Payment</a>
                            
                    
                        <li class="nav-item">
                            <a class="nav-link" href="About.html"><i class="bi bi-info-circle"></i>About</a>
                        </li>
                        <li class="nav-item"></li>
                            <a class="nav-link" href="logout.php"> <i class="bi bi-box-arrow-right"></i>Log out</a>
                        </li>
                    </ul>
                </div>
            </nav>
            
  <!-- Main Content -->
      <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
        <div class="form-box">
          <h2>Edit Personal Details</h2>
          <form method="POST" action="update_personal.php">
            <label for="name">Full Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" value="<?= htmlspecialchars($user['dob']) ?>" required>

            <label for="gender">Gender:</label>
            <select name="gender" required>
              <option value="">Select</option>
              <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
              <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
              <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>

            <label for="travel-style">Preferred Travel Style:</label>
            <select id="travel-style" name="travel_style" required>
              
              <option value="budget" <?= $user['travel_style'] == 'budget' ? 'selected' : '' ?>>Budget</option>
              <option value="luxury" <?= $user['travel_style'] == 'luxury' ? 'selected' : '' ?>>Luxury</option>
              <option value="adventure" <?= $user['travel_style'] == 'adventure' ? 'selected' : '' ?>>Adventure</option>
              <option value="relaxation" <?= $user['travel_style'] == 'relaxation' ? 'selected' : '' ?>>Relaxation</option>
              <option value="cultural" <?= $user['travel_style'] == 'cultural' ? 'selected' : '' ?>>Cultural</option>

            </select>

            <label for="address">Address:</label>
            <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
 
 <label>Travel Interests(optional):</label>
<div class="travel-interest">
  <?php
      // Safely explode travel interests into an array
      $interests = isset($user['travel_interests']) ? array_map('trim', explode(',', $user['travel_interests'])) : [];
      
      function isChecked($value, $interests) {
        return in_array($value, $interests) ? 'checked' : '';
      }
    ?>
    <label><input type="checkbox" name="travel_interests[]" value="nature" <?= isChecked('nature', $interests) ?>> Nature</label>
    <label><input type="checkbox" name="travel_interests[]" value="history" <?= isChecked('history', $interests) ?>> History</label>
    <label><input type="checkbox" name="travel_interests[]" value="wildlife" <?= isChecked('wildlife', $interests) ?>> Wildlife</label>
    <label><input type="checkbox" name="travel_interests[]" value="beaches" <?= isChecked('beaches', $interests) ?>> Beaches</label>
    <label><input type="checkbox" name="travel_interests[]" value="food" <?= isChecked('food', $interests) ?>> Food</label>
    <label><input type="checkbox" name="travel_interests[]" value="shopping" <?= isChecked('shopping', $interests) ?>> Shopping</label>
  </div>

           
            <button type="submit">update</button>
          </form>
        </div>
      </main>
    




    </div>
    </div>
</body>
</html>
