<?php
include 'connect.php';

// Function to sanitize user inputs
function sanitize($conn, $input) {
    return mysqli_real_escape_string($conn, trim($input));
}

// Check if the domain of the email is allowed
function isValidDomain($email) {
    $allowedDomains = ['gmail.com', 'yahoo.com', 'outlook.com'];
    $emailDomain = substr(strrchr($email, "@"), 1); // Get domain part of email
    return in_array($emailDomain, $allowedDomains);
}

// Function to validate the password format
function validatePassword($password) {
    // Define the regex pattern for password validation
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/';

    // Check if the password matches the regex pattern
    if (preg_match($pattern, $password)) {
        return true; // Password meets the criteria
    } else {
        return false; // Password does not meet the criteria
    }
}

// Initialize variables to hold error messages
$registrationMessage = "";
$loginMessage = "";

// Handle user registration
if(isset($_POST['signUp'])) {
    $firstName = sanitize($conn, $_POST['fName']);
    $lastName = sanitize($conn, $_POST['lName']);
    $email = sanitize($conn, $_POST['email']);
    $password = md5($_POST['password']);

    if (!isValidDomain($email)) {
        $registrationMessage = "Registration failed: Invalid Email domain.";
    } elseif (!validatePassword($_POST['password'])) {
        $registrationMessage = "Password must be at least 8 characters long and contain at least one letter, one number, and one special character.";
    } else {
        // Check if the email already exists
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if($result->num_rows > 0) {
            $registrationMessage = "Email Address Already Exists!";
        } else {
            // Insert new user into the database
            $insertQuery = "INSERT INTO users (firstName, lastName, email, password, approved)
                            VALUES ('$firstName', '$lastName', '$email', '$password', 0)";

            if($conn->query($insertQuery) === TRUE) {
                $registrationMessage = "Registration Successful! Waiting for admin approval.It will be approved within 3hours";
            } else {
                $registrationMessage = "Error: " . $conn->error;
            }
        }
    }
}

// Handle user login
if(isset($_POST['signIn'])) {
    $email = sanitize($conn, $_POST['email']);
    $password = md5($_POST['password']); // Hash the provided password

    // Checking if the user exists and is approved
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifying if the provided password matches the hashed password stored in the database
        if(md5($_POST['password']) == $row['password']) {
            if($row['approved'] == 1) {
                session_start();
                $_SESSION['email'] = $email;
                header("Location: homepage.php");
                exit();
            } else {
                $loginMessage = "Your account is not yet approved by the admin. Please wait for approval.";
            }
        } else {
            $loginMessage = "Incorrect Password or email";
        }
    } else {
        $loginMessage = "User with this email does not exist or rejected by admin";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Registration</title>
    <link rel="stylesheet" href="regstyle.css">
</head>
<body>
    <div class="message-container">
        <?php
        if (isset($registrationMessage)) {
            if (strpos($registrationMessage, 'Registration Successful') !== false) {
                echo '<div class="message success border">' . $registrationMessage . '</div>';
            } else {
                echo '<div class="message error">' . $registrationMessage . '</div>';
            }
        }
        ?>

        <?php
        if (isset($loginMessage)) {
            if (strpos($loginMessage, 'Incorrect Password') !== false || strpos($loginMessage, 'does not exist') !== false) {
                echo '<div class="message error">' . $loginMessage . '</div>';
            } else {
                echo '<div class="message success border">' . $loginMessage . '</div>';
            }
        }
        ?>
    </div>
</body>
</html>

