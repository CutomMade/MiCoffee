<?php
use SendGrid\Mail\Mail;

include 'config.php';
require_once 'email.php';
require 'vendor/autoload.php';

// Set your SendGrid API key here
$sendgridApiKey = SENDGRID_API_KEY;

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $user_type = mysqli_real_escape_string($conn, $_POST['user_type']);
    $admin_code = mysqli_real_escape_string($conn, $_POST['admin_code']); // Assuming this is the field for admin code

    $message = array();

    // Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message[] = 'Invalid email format!';
    }

    // Password Validation
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/\d/', $password)) {
        $message[] = 'Password should be at least 8 characters, contain at least one capital letter, and one number.';
    }

    // If the selected user type is "admin," check the admin code
    if ($user_type === 'admin' && $admin_code !== 'DenzelRocks') {
        $message[] = 'Invalid admin code!';
    }

    // Check if the passwords match
    if ($password !== $cpassword) {
        $message[] = 'Confirm password not matched!';
    }

    if (empty($message)) {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Generate OTP
        $otp = mt_rand(100000, 999999); // 6-digit OTP

        // Get current timestamp
        $otpTimestamp = time();

        // Insert OTP and timestamp into the email_verification table
        $insertOtpQuery = "INSERT INTO `email_verification` (name, password, email, otp, timestamp, user_type) VALUES ('$name', '$hashed_password', '$email', '$otp', '$otpTimestamp', '$user_type')";
        mysqli_query($conn, $insertOtpQuery);

        // Send OTP via email
        $emailM = new \SendGrid\Mail\Mail();
        $emailM->setFrom("denzelhadebe7@gmail.com", "MiCoffee");
        $emailM->setSubject("Email Confirmation");
        $emailM->addTo($email, $name);
        $emailM->addContent("text/plain", "Your OTP is: $otp");

        $sendgrid = new \SendGrid($sendgridApiKey);
        try {
            $response = $sendgrid->send($emailM);
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

        // Redirect to verification page with email parameter
        header('location: verification.php?email=' . urlencode($email));
        exit();
    }
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<div class="form-container">
   <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Enter your name" required class="box">
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="Confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">User</option>
         <option value="admin">Admin</option>
      </select>
      <input type="text" name="admin_code" placeholder="Admin Code (Optional)" class="box">
      <input type="submit" name="submit" value="Register Now" class="btn">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</div>
</body>
</html>
