<?php
session_start();
include("connect.php");

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Interface</title>
    <link rel="stylesheet" href="userinterface.css">
    <link rel="stylesheet" href="homestyle.css">
    <style>
        body {
            background-color: black;
            background-image: url('bg.png');
            background-size: 1500px 800px;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white; /* Set global text color */
            font-size: 18px; 
        }
        
        .container {
            text-align: center;
            background-color: black;
            padding: 20px;
            border-radius: 10px;
        }
        
        .content-item {
            margin-bottom: 20px;
        }
        
        .content-item h4 {
            color:white; 
        }
        
        .content-item p {
            color: lightgray;
        }
        
        .content-item a {
            color: cyan; 
        }
    </style>
</head>
<body>
<div class="button-container">
            <button onclick="location.href='index.php'">Logout</button>
            <button onclick="location.href='ourstory.php'">Our Story</button>
            <button onclick="location.href='nextpage.php'">Next Page</button>
        </div>
    <div class="container">
        <h2>Content</h2>
        <div class="content">
            <?php
            // Fetch and display content for the logged-in user based on their email
            $stmt = $conn->prepare("SELECT c.*, u.email as user_email FROM content c JOIN users u ON c.user_id = u.id WHERE u.email = ?");
            $stmt->bind_param("s", $user_email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='content-item'>";
                    echo "<h4>" . $row['title'] . "</h4>";
                    echo "<p>Type: " . $row['type'] . "</p>";
                    echo "<p>User: " . $row['user_email'] . "</p>";
                    
                    if ($row['type'] == 'text') {
                        echo "<p>" . $row['content_data'] . "</p>";
                    } elseif ($row['type'] == 'video' || $row['type'] == 'image') {
                        echo "<p><a href='" . $row['content_data'] . "' target='_blank'>View File</a></p>";
                    }
                    
                    echo "</div>";
                }
            } else {
                echo "<p>No content available.</p>";
            }
            
            $stmt->close();
            ?>
        </div>
    </div>
</body>
</html>
