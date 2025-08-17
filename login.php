
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
    <style>
        /* Center the message on the page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: linear-gradient(rgba(21, 33, 79, 0.7),rgba(4,9,30,0.7)),url('img/intro.jpg')  ;
            background-size: cover;
           
        }
        
        /* Style the message box */
        .message {
            padding: 20px 40px;
            background-color: rgb(229, 224, 225) ; 
            border: 2px solid rgb(220, 6, 6);
            border-radius: 8px;
            color:rgb(220, 6, 6); 
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="message">
<?php
//start the session at the beginning of the file
session_start();

// denote the variables

$email = $_POST['email'];
$password = $_POST['password'];

//check value emptyness
if(!empty($email)||!empty($password))
{
    $host = "localhost";
    $dbusername ="root";
    $dbpassword = "";
    $dbname = "travel_planner";

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

    // Prepare and execute SQL statement to get the user with the entered email
    $stmt = $conn->prepare("SELECT password FROM register WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        // Bind result and fetch stored password
        $stmt->bind_result($stored_password);
        $stmt->fetch();
        

        //debug output
        //echo"Entered password:". $password . "<br>";
        //echo"password from database:". $stored_password . "<br>";

        // Verify the entered password with the stored password
        if ($password== $stored_password) {
            $_SESSION['email'] = $email;
          
            //Redirect to dashboard or homepage
            header("Location:code.html");
            exit();
            
        } else {
           
            echo "Incorrect password.";
            echo'<br>';
            echo'<a class="link" href="log in.html"> Try again </a>';
        }
    } else {
        echo "No account found with that email.";
        echo'<br>';
        echo'<a class="link" href="log in.html"> Try again </a>';
    }
    // Close the statement
    $stmt->close();
}
// Close the connection
$conn->close();
}
?>
 </div>
</body>
</html>

