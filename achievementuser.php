<?php
// Start session 
session_start();
include("connect.php"); 

// Fetch achievements
$achievements = [];
$achievements_query = "SELECT * FROM achievements";
$achievements_result = $conn->query($achievements_query);

if ($achievements_result) {
    if ($achievements_result->num_rows > 0) {
        while ($row = $achievements_result->fetch_assoc()) {
            $achievements[] = $row;
        }
    }
} else {
    $message = "Error fetching achievements: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Achievements</title>
    <link rel="stylesheet" href="homestyle.css">
    <style>
        /* Styling for the background image */
        body {
            background-image: url('bg.png');
            background-size: cover;
            background-attachment: fixed;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Center the container */
        .container {
            max-width: 800px;
            margin: 20px auto 20px 10%;
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        /* Table styling for achievements */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.8);
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #4CAF50;
            color: white;
        }

        table td {
            color: black;
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
        <h3>Our Achievements</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
            </tr>
            <?php foreach ($achievements as $achievement): ?>
                <tr>
                    <td><?php echo $achievement['id']; ?></td>
                    <td><?php echo $achievement['title']; ?></td>
                    <td><?php echo $achievement['description']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
