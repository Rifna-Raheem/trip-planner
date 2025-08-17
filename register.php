
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
            background-color: #959697;
            background-image: linear-gradient(rgba(21, 33, 79, 0.7),rgba(4,9,30,0.7)),url('img/intro.jpg')  ;
            background-size: cover;
           
        }
        
        /* Style the message box */
        .message {
            padding: 20px 40px;
            background-color: rgba(237, 226, 228, 0.88) ; 
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


// denote the variables

$User_name = $_POST['User_name']; 
$email = $_POST['email'];
$Phone_number = $_POST['Phone_number'];
$password = $_POST['password']; 


//check value emptyness
if(!empty($User_name)||!empty($email)||!empty($Phone_number)||!empty($password))
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
    //set email  uniqueness
    $SELECT = "SELECT email From register where email = ? Limit 1 ";
   

    //insert the values in database
    $INSERT = "INSERT Into register(User_name,email,Phone_number,password) values(?,?,?,?) ";


    // Prepare and bind SQL statement for SELECT key
    $stmt = $conn->prepare($SELECT);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->store_result();
    $rnum = $stmt->num_rows;

    // check if the data was inserted successfully
    if ($rnum==0) {  //check email  unique
        $stmt->close();
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ssss",$User_name, $email,$Phone_number,$password);
        
        
        if ($stmt->execute()) {
             //Redirect to login page with typing effect massage
            
    echo '
    <div class="typing-container">
        <span class="typing-text" id="typing"></span>
    </div>
    <script>
        const message = "✅ Registration successful! Redirecting to login page...";
        let i = 0;
        const speed = 50; // Typing speed in milliseconds

        function typeWriter() {
            if (i < message.length) {
                document.getElementById("typing").innerHTML += message.charAt(i);
                i++;
                setTimeout(typeWriter, speed);
            }
        }

        typeWriter();

        // Redirect after 5 seconds
        setTimeout(() => {
            window.location.href = "log in.html";
        }, 5000);
    </script>
    <style>
        .typing-container {
            font-family: "Segoe UI", sans-serif;
            font-size: 1.5rem;
            color: rgba(6, 152, 220, 1);
            text-align: center;
        }

        .typing-text {
            border-right: 2px solid;
            white-space: nowrap;
            overflow: hidden;
            display: inline-block;
            animation: blink-caret 0.75s step-end infinite;
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: rgb(220, 6, 6); }
        }
    </style>';


        } else {
          echo "Someone already registered using this phone number";
          echo '<br>';
          echo'<a class="link" href="Sign up.html">Try again</a>';
        }


    } else {
        echo "Someone already registered using this email " . $stmt->error;
        echo '<br>';
        echo'<a class="link" href="Sign up.html">Try again</a>';
    }

    // Close the statement
    $stmt->close();


    // Close the connection
    $conn->close();
}

?>
    </div>
</body>
</html>

    