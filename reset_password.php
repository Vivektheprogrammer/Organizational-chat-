<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            background-image: url('bg.png'); 
            background-size: cover;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php
         include 'connect.php';
        if (isset($_GET['token'])) {
            $token = $_GET['token'];

            // Checking if token exists and is not expired
            $sql = "SELECT * FROM users WHERE reset_token='$token' AND reset_token_expiry > NOW()";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                // Token is valid, show reset password form
                ?>
                <form action="update_password.php" method="post">
                    <input type="hidden" name="token" value="<?php echo $token; ?>">
                    <label for="password">Enter new password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Reset Password</button>
                </form>
                <?php
            } else {
                echo "Invalid or expired token.";
            }
        } else {
            echo "Invalid request.";
        }
        ?>
    </div>
</body>
</html>
