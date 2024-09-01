<?php
    // Start the PHP session
    session_start();
    
    // Include the database configuration file
    include_once "config.php";
    
    // Get the unique ID of the current user from the session
    $outgoing_id = $_SESSION['unique_id'];
    
    // SQL query to select users except the current user, ordered by user_id in descending order
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} ORDER BY user_id DESC";
    
    // Execute the SQL query
    $query = mysqli_query($conn, $sql);
    
    // Initialize an empty output string
    $output = "";
    
    // Check if there are no users available for chat
    if(mysqli_num_rows($query) == 0){
        // If no users are available, add a message to the output string
        $output .= "No users are available to chat";
    }
    // If there are users available for chat
    elseif(mysqli_num_rows($query) > 0){
        // Include data.php to process and display user information
        include_once "data.php";
    }
    
    // Output the result
    echo $output;
?>
