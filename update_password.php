<?php
include 'connect.php';

function sanitize($conn, $input) {
    $input = trim($input);
    $input = mysqli_real_escape_string($conn, $input);
    return $input;
}

$message = '';

if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = sanitize($conn, $_POST['token']);
    $password = md5($_POST['password']); // Hash the new password

    // Update password in database
    $updatePasswordQuery = "UPDATE users SET password='$password', reset_token='', reset_token_expiry=NULL WHERE reset_token='$token'";
    if ($conn->query($updatePasswordQuery) === TRUE) {
        $message = "Password updated successfully.";
    } else {
        $message = "Error updating password: " . $conn->error;
    }
} else {
    $message = "Invalid request.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('log.jpg');
            background-size: cover;
        }
        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .message {
            margin-top: 40px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
         <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : ''; ?>">
        </form>
    </div>
</body>
</html>
