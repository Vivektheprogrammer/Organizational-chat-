<?php
  // Database credentials
  $hostname = "localhost"; // Hostname where the MySQL database is located
  $username = "root";      // Username to access the database
  $password = "";          // Password to access the database
  $dbname = "chatapp";     // Name of the database to connect to

  // Establishing a connection to the MySQL database
  $conn = mysqli_connect($hostname, $username, $password, $dbname);

  // Check if the connection is successful
  if(!$conn){
    // If connection fails, display an error message with the reason
    echo "Database connection error" . mysqli_connect_error();
  }
?>
