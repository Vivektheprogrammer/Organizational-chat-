<?php
    // Start the PHP session
    session_start();
    
    // Check if the user is logged in (i.e., if their unique_id is set in the session)
    if(isset($_SESSION['unique_id'])){
        // Include the database configuration file
        include_once "config.php";
        
        // Sanitize the logout_id from the GET request
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        
        // Check if logout_id is set
        if(isset($logout_id)){
            // Update the user's status to "Offline now" in the database
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            
            // Check if the status update was successful
            if($sql){
                // Unset and destroy the session
                session_unset();
                session_destroy();
                
                // Redirect the user to the login page
                header("location: ../login.php");
            }
        }else{
            // If logout_id is not set, redirect the user to the users page
            header("location: ../users.php");
        }
    }else{  
        // If the user is not logged in, redirect them to the login page
        header("location: ../login.php");
    }
?>
