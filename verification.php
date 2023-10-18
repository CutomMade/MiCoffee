<?php
session_start();
include 'config.php';
require_once 'email.php';

if(isset($_POST['email']) && isset($_POST['otp'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);

    // Check if the email and OTP combination exists in the email_verification table
    $checkOtpQuery = "SELECT * FROM `email_verification` WHERE email='$email' AND otp='$otp'";
    $result = mysqli_query($conn, $checkOtpQuery);

    if(mysqli_num_rows($result) > 0){
        // Get user data from email_verification table
        $userData = mysqli_fetch_assoc($result);

        // Store user data in session variables
        $_SESSION['name'] = $userData['name'];
        $_SESSION['email'] = $userData['email'];
        $_SESSION['password'] = $userData['password'];
        $_SESSION['user_type'] = $userData['user_type'];

        // Insert the verified user into the users table
        $insertUserQuery = "INSERT INTO `users` (name, email, password, user_type) VALUES ('{$_SESSION['name']}', '{$_SESSION['email']}', '{$_SESSION['password']}', '{$_SESSION['user_type']}')";
        if(mysqli_query($conn, $insertUserQuery)){
            // User inserted successfully, you can now redirect to login page or wherever needed
            header('location: login.php?verified=true');
            exit();
        } else {
            // Error occurred during user insertion
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid OTP or Email.";
    }
} else {
    
}
?>







<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   <div class="form-container">
      <form action="verification.php" method="post">
         <h3>Email Verification</h3>
         <p> An OTP has been sent to your email, please enter your email and the OTP that was sent to you below.</p>
         <?php if(isset($message)) { echo '<p class="message">'.$message.'</p>'; } ?>
         <input type="email" name="email" placeholder="Enter your email" required class="box">
         <input type="text" name="otp" placeholder="Enter the OTP" required class="box">
         <input type="submit" name="submit" value="Verify Email" class="btn">
      </form>
   </div>
</body>
</html>