<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Status</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            background: #ffffff;
            color: #333;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            width: 400px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.3);
            animation: fadeIn 0.6s ease-in-out;
        }
        /* Placeholder Logo */
        .logo {
            width: 80px;
            height: 80px;
            background: #007bff;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
        }
        /* Placeholder Illustration */
        .illustration {
            width: 100%;
            max-width: 120px;
            height: 120px;
            background: #f0f0f0;
            border-radius: 12px;
            margin: 15px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 50px;
            color: #ccc;
        }
        .message-text {
            font-size: 18px;
            margin: 20px 0;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #d9534f;
            font-weight: bold;
        }
        .link {
            color: #fff;               
            background-color: #007bff;    
            padding: 10px 18px;            
            border-radius: 6px;           
            text-decoration: none;        
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .link:hover {
            background-color: #0056b3;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
<div class="container">
    
    <div class="illustration" id="statusImage">✔</div> <!-- Success by default -->

    <div class="message-text" id="statusMessage">
        <?php
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';
        require 'PHPMailer/src/Exception.php';

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        if(isset($_POST["Message"])){  
            $name  = $_POST["name"];
            $email  = $_POST["email"];
            $subject  = $_POST["subject"];
            $message  = $_POST["message"];

            $mail = new PHPMailer;
            $mail->isSMTP();                                      
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;                               
            $mail->Username = 'abdulraheemrifna06@gmail.com';                 
            $mail->Password = 'hvvx losx wjtt ruyw';                           
            $mail->SMTPSecure = 'tls';                            
            $mail->Port = 587;                                    

            $mail->setFrom('abdulraheemrifna06@gmail.com', $name);
            $mail->addAddress('abdulraheemrifna06@gmail.com');     
            $mail->isHTML(true);                                  

            $mail->Subject = 'New Contact Form Submission: ' . $subject;
            $mail->Body    = 'Name: '. $name .'<br>'.'Email: '. $email .'<br>'.'Message: '.$message ;

            if(!$mail->send()) {
                echo '<span class="error">Message could not be sent. Please try again later.</span>';
                echo '<script>document.getElementById("statusImage").innerHTML = "✖";</script>'; // Error icon
            } else {
                echo '<span class="success">Thank you for contacting us! We will get back to you soon.</span>';
                echo '<script>document.getElementById("statusImage").innerHTML = "✔";</script>'; // Success icon
            }
        }
        ?>
    </div>
    <a class="link" href="code.html">Go to Homepage</a>
</div>
</body>
</html>
