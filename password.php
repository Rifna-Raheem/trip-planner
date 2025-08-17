<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>password</title>
    <style>
        /* Center the message on the page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(21, 33, 79, 0.7),rgba(4,9,30,0.7)),url('img/intro.jpg');
            background-size: cover;
        }
        
        /* Style the message box */
        .message {
            padding: 20px 40px;
            background-color: rgb(244, 236, 238); 
            border: 2px solid;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        .success {
            color: green;
            border-color: green;
        }
        .error {
            color: rgb(220, 6, 6);
            border-color: rgb(220, 6, 6);
        }
        .link {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<?php

// denote the variables
$User_name = $_POST['User_name'];
$email = $_POST['email'];
$Phone_number = $_POST['Phone_number'];

//check value emptyness
if(!empty($User_name)||!empty($email)||!empty($Phone_number))
{
    $host = "localhost";
    $dbusername ="root";
    $dbpassword = "";
    $dbname = "Travel_Planner";
}

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and execute SQL statement
        $stmt = $conn->prepare("SELECT password FROM register WHERE User_name = ? and email = ? and Phone_number = ?");
        $stmt->bind_param("ssi", $User_name,$email,$Phone_number);
        $stmt->execute();
        $result = $stmt->get_result();

        // Determine class based on result
        $messageClass = ($result->num_rows > 0) ? 'success' : 'error';

        echo '<div class="message '.$messageClass.'">';
        // Check if user exists
        if ($result->num_rows > 0) {
            echo "Password reset link sent to your email.";
            echo '<br>Please check.';
            echo '<br><a class="link" href="Home.html">Go to Home</a>';
        } else {
            echo "No account found with that details.";
            echo '<br><a class="link" href="Home.html">Go to Home</a>';
        }
        echo '</div>';
        $stmt->close();
    }
    $conn->close();
}
?>
</body>
</html>
