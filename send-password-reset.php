<?php
require_once 'email.php';
require 'vendor/autoload.php'; // Include SendGrid library

if (isset($_POST["email"])) {
    $recipientEmail = $_POST["email"]; // Use a different variable for recipient email

    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 5);

    $mysqli = require __DIR__ . "/config.php";

    $sql = "UPDATE users
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $token_hash, $expiry, $recipientEmail); // Use the recipient's email

        $stmt->execute();

        if ($mysqli->affected_rows) {
            $sendgrid = new \SendGrid(SENDGRID_API_KEY);

            $email = new \SendGrid\Mail\Mail();
            $email->setFrom("denzelhadebe7@gmail.com", "Micoffe");
            $email->setSubject("Password Reset");
            $email->addTo($recipientEmail, "Recipient Name"); // Set recipient's email

            $email->addContent(
                "text/html",
                "Click <a href='http://localhost:3000/reset-password.php?token=$token'>here</a> to reset your password."
            );

            try {
                $response = $sendgrid->send($email);

                if ($response->statusCode() == 202) {
                    echo "Message sent, please check your inbox.";
                } else {
                    echo "Failed to send email. Status Code: " . $response->statusCode();
                }
            } catch (Exception $e) {
                echo 'Caught exception: ' . $e->getMessage() . "\n";
            }
        } else {
            echo "Failed to update the database.";
        }
    } else {
        echo "Failed to prepare the SQL statement: " . $mysqli->error;
    }
} else {
    echo "Email not provided.";
}
?>
