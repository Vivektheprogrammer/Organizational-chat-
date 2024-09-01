<?php
session_start();
include("connect.php");

// Handle admin login
if(isset($_POST['ltcp'])) {
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $admin_email, $admin_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        // Admin login successful
        $_SESSION['admin'] = $admin_email;
        header("Location: adminhome.php");
        exit();
    } else {
        // Admin login failed
        $error = "Invalid email or password";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if(isset($error)) echo "<p>$error</p>"; ?>
        <form method="post" action="">
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                <label for="email">Email:</label><br>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required><br><br>
                <label for="password">Password:</label><br>
            </div>
            <input type="submit" name="ltcp" value="Login">
        </form>
        <div class="links">
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="text-decoration: none; color: blue; display: inline-block; padding: 10px 20px; background-color: #f0f0f0; border-radius: 5px;">User Login</a>
    </div>
</body>
</html>
