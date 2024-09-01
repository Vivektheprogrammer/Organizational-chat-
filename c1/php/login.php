<?php 
    // Start the PHP session
    session_start();
    
    // Include the database configuration file
    include_once "config.php";
    
    // Get the email and password from the POST request and sanitize them
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if both email and password are not empty
    if(!empty($email) && !empty($password)){
        // Query the database to check if the email exists
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        
        // Check if there is a user with the provided email
        if(mysqli_num_rows($sql) > 0){
            // Fetch the user data
            $row = mysqli_fetch_assoc($sql);
            
            // Encrypt the provided password using MD5 (not recommended for security reasons)
            $user_pass = md5($password);
            
            // Retrieve the encrypted password from the database
            $enc_pass = $row['password'];
            
            // Compare the provided password with the one stored in the database
            if($user_pass === $enc_pass){
                // If the passwords match, update the user's status to "Active now"
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                
                // Check if the status update was successful
                if($sql2){
                    // If successful, set the user's unique ID in the session and return "success"
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    // If the status update fails, return an error message
                    echo "Something went wrong. Please try again!";
                }
            }else{
                // If the passwords don't match, return an error message
                echo "Email or Password is Incorrect!";
            }
        }else{
            // If the email does not exist in the database, return an error message
            echo "$email - This email not Exist!";
        }
    }else{
        // If either email or password is empty, return an error message
        echo "All input fields are required!";
    }
?>
