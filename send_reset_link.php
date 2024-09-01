<?php
// Include PHPMailer autoload file
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to send password reset email
function sendPasswordResetEmail($email, $resetLink) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Specify SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'vivekrkdc2021bca@gmail.com'; // SMTP username
        $mail->Password = 'jkscfjzevqbmdlkx'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Sender and recipient settings
        $mail->setFrom('vivekrkdc2021bca@gmail.com', 'langtranspo');
        $mail->addAddress($email); // Add a recipient
        $mail->addReplyTo('vivekrkdc2021bca@gmail.com', 'feedback');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = "Click the link to reset your password: $resetLink";
        
        // Send email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // Something went wrong
        return false;
    }
}

// Function to sanitize user inputs
function sanitize($conn, $input) {
    // Trim whitespace
    $input = trim($input);
    // Remove special characters that might be used in SQL injection attacks
    $input = mysqli_real_escape_string($conn, $input);
    // Optionally, you can also perform additional sanitization steps here
    return $input;
}
include 'connect.php';

if(isset($_POST['email'])) {
    $email = sanitize($conn, $_POST['email']);
    
    // Check if email exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        // Generate and store token in database
        $token = bin2hex(random_bytes(32)); // Generate random token
        $expiry = date('Y-m-d H:i:s', strtotime('+1 day')); // Set expiry time
        
        // Store token and expiry time in the database
        $updateTokenQuery = "UPDATE users SET reset_token='$token', reset_token_expiry='$expiry' WHERE email='$email'";
        if($conn->query($updateTokenQuery) === TRUE) {
            // Send email with reset link
            $resetLink = "http://localhost/ocfinal/reset_password.php?token=$token";
            // Use PHPMailer to send email
            if (sendPasswordResetEmail($email, $resetLink)) {
                header("Location: password_reset_instructions.php");
            } else {
                echo "Error sending email. Please try again later.";
            }
        } else {
            echo "Error updating token in the database.";
        }
    } else {
        echo "User with this email does not exist.";
    }
} else {
    echo "Invalid request.";
}
?>

