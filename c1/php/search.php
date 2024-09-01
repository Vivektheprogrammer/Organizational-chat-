<?php
    // Start the PHP session
    session_start();

    // Include the database configuration file
    include_once "config.php";

    // Get the unique_id of the current user from the session
    $outgoing_id = $_SESSION['unique_id'];
    
    // Sanitize the search term from the POST request
    $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);

    // SQL query to search for users based on the search term
    $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ";
    
    // Initialize output variable
    $output = "";

    // Execute the SQL query
    $query = mysqli_query($conn, $sql);

    // Check if any users are found
    if(mysqli_num_rows($query) > 0){
        // Include the data.php file to display user information
        include_once "data.php";
    }else{
        // If no users are found, generate a message
        $output .= 'No user found related to your search term';
    }

    // Output the result
    echo $output;
?>
