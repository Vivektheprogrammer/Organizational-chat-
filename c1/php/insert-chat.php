<?php 
    // Start the PHP session
    session_start();
    
    // Check if the user is logged in
    if(isset($_SESSION['unique_id'])){
        
        // Include the database configuration file
        include_once "config.php";
        
        // Get the outgoing user's unique ID from the session
        $outgoing_id = $_SESSION['unique_id'];
        
        // Get the incoming user's unique ID from the POST request
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
        
        // Get the message from the POST request and sanitize it
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        
        // Check if the message is not empty
        if(!empty($message)){
            // If the message is not empty, insert it into the database
            $sql = mysqli_query($conn, "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                                        VALUES ({$incoming_id}, {$outgoing_id}, '{$message}')") or die();
        }
    }else{
        // If the user is not logged in, redirect to the login page
        header("location: ../login.php");
    }
?>
