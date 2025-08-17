<?php
session_start();
include 'db.php';
$email = $_SESSION['email'] ?? null;

// Fetch all personal details
$sql = "SELECT name, dob, gender, travel_style, address, travel_interests FROM personal_details WHERE email = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view personal details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet"> <!--link for boostrap icons-->
    <link rel="stylesheet" href="code_style.css">
    <!--to use the google font design -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

<style> 
    
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

   } 
    .main-content h2{
        /*from google fonts*/
        font-family: "Playfair Display", serif;
        font-size: 50px;
        
    } 
    .card-title {
      color: hsl(205, 100%, 23%);
      font-family: 'Playfair Display', serif;
      
    }
     .card {
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
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
            


 <!-- Main content -->
  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-5 main-content d-flex flex-column align-items-center">
  <h2 class="text-center mb-5 ">Personal Profile</h2>

  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="card p-4 mb-4 w-100" style="max-width: 500px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 15px;">
        <div class="card-body">
          <h5 class="card-title text-primary" style="font-family: 'Playfair Display', serif;"><strong><?= htmlspecialchars($row['name']) ?></strong></h5>
          <p class="mb-2"><strong>Date of Birth:</strong> <?= htmlspecialchars($row['dob']) ?></p>
          <p class="mb-2"><strong>Gender:</strong> <?= htmlspecialchars($row['gender']) ?></p>
          <p class="mb-2"><strong>Travel Style:</strong> <?= htmlspecialchars($row['travel_style']) ?></p>
          <p class="mb-2"><strong>Address:</strong><br><?= nl2br(htmlspecialchars($row['address'])) ?></p>
          <p class="mb-3"><strong>Travel Interests:</strong><br><?= nl2br(htmlspecialchars($row['travel_interests'])) ?></p>

          <!-- Edit Button -->
          <a href="edit_personal.php" class="btn btn-warning">Edit Details</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="text-center text-muted">
      <p>No personal profile found.</p>
    </div>
  <?php endif; ?>

  
</main>

 
     

</body>
</html>