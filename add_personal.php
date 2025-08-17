
<?php
session_start(); 

include 'db.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email=$_SESSION['email'];
    $name = trim($_POST['name']);
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $travel_style = $_POST['travel_style'];
    $address = trim($_POST['address']);
    $travel_interests = null;
       if (isset($_POST['travel_interests'])) {
         if (is_array($_POST['travel_interests'])) {
        $travel_interests = implode(", ", $_POST['travel_interests']);
         } else {
        $travel_interests = $_POST['travel_interests'];
         }
        }
    // First check if a record already exists for this email
    $check = $conn->prepare("SELECT id FROM personal_details WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        // Record exists → UPDATE
        $stmt = $conn->prepare("UPDATE personal_details SET name = ?, dob = ?, gender = ?, travel_style = ?, address = ?, travel_interests = ?, updated_at = NOW() WHERE email = ?");
        $stmt->bind_param("sssssss", $name, $dob, $gender, $travel_style, $address, $travel_interests, $email);
    } else {
        // No record → INSERT

    $stmt = $conn->prepare("INSERT INTO personal_details (email, name, dob, gender, travel_style, address, travel_interests) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss",$email, $name, $dob, $gender, $travel_style, $address, $travel_interests);

    }
    if ($stmt->execute()) {
        // Show success message and redirect using HTML
        echo "
        <html>
        <head>
            <meta http-equiv='refresh' content='4;url=code.html'>
            <style>
                body { font-family: Arial; text-align: center; margin-top: 100px; }
            </style>
        </head>
        <body>
            <h2>Personal details added successfully!</h2>
            <p>You will be redirected to the homepage shortly...</p>
        </body>
        </html>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
