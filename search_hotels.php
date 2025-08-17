<?php
// DB connection
$conn = new mysqli("localhost", "root", "", "travel_planner");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input

$destination = isset($_GET['destination']) ? $_GET['destination'] : '';
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$guests = isset($_GET['num_guests']) ? $_GET['num_guests'] : '';


// Fetch matching hotels
$sql = "SELECT * FROM hotels WHERE location LIKE ?";
$stmt = $conn->prepare($sql);
$searchDest = "%" . $destination . "%";
$stmt->bind_param("s", $searchDest);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Hotel Results</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .hotel-card {
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    .carousel-inner img {
      height: 200px;
      object-fit: cover;
    }
    
    .go-back-btn {
   
    width: 15%;
    padding: 10px;
    background: #007bff; /* Bootstrap Blue */
    color: #ffffff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    margin-top: 20px;
    margin-left: 2px;
    
}

.go-back-btn:hover {
    background: #0056b3; /* Darker Blue on Hover */
}
    .rating {
      font-size: 14px;
      font-weight: bold;
      color: #fff;
      background-color: #28a745;
      padding: 4px 10px;
      border-radius: 6px;
    }

    .btn-availability {
      margin-top: 15px;
    }
    .container {
  max-width: 1000px;
}

  </style>
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Available Hotels in <?php echo htmlspecialchars($destination); ?></h3>

  <?php if ($result->num_rows > 0): ?>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="row g-4 align-items-start hotel-card bg-white p-4">

      <div class="col-md-4 mb-3 mb-md-0">
        <div id="carousel<?php echo $row['hotel_id']; ?>" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="img/<?php echo $row['image1']; ?>" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="img/<?php echo $row['image2']; ?>" class="d-block w-100">
            </div>
            <div class="carousel-item">
              <img src="img/<?php echo $row['image3']; ?>" class="d-block w-100">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carousel<?php echo $row['hotel_id']; ?>" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel<?php echo $row['hotel_id']; ?>" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>

      <div class="col-md-8 ps-md-4">

        <h4><?php echo $row['name']; ?></h4>
        <p><?php echo $row['location']; ?></p>
        <span class="rating"><?php echo $row['rating']; ?> ★</span>
        <p class="mt-2"><?php echo $row['description']; ?></p>
        <p><strong>$<?php echo $row['price_per_night']; ?></strong> per night</p>
        <a href="book_now.php?hotel_id=<?php echo $row['hotel_id']; ?>&checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>&num_guests=<?php echo $guests; ?>" class="btn btn-primary btn-availability">See Availability</a>

        
      </div>
    </div>
  <?php endwhile; ?>

 <?php else: ?>
  <div class="alert alert-warning mt-4">
    <h5>Sorry, no hotels found for "<?php echo htmlspecialchars($destination); ?>".</h5>
    <p>In the future, we will expand to support more destinations.</p>
    <p><strong>Currently supported destinations:</strong> Kandy, Colombo, Galle, Nuwara Eliya, Anuradhapura, Jaffna.</p>
    <p>Thank you for your understanding.</p>
    <button type="submit" class="btn btn-primary go-back-btn" onclick="location.href='bookHotel.html'">Go back</button>
  </div>
<?php endif; ?>


</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
