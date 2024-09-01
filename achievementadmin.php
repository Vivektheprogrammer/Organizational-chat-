<?php
session_start();
include("connect.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Initialize message variable
$message = '';

// Process form submission to add achievement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_achievement'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Insert achievement
    $stmt = $conn->prepare("INSERT INTO achievements (title, description) VALUES (?, ?)");
    if ($stmt) {
        $stmt->bind_param("ss", $title, $description);
        if ($stmt->execute()) {
            $message = "Achievement added successfully";
            // Redirect to prevent duplicate submissions on refresh
            header("Location: achievementadmin.php");
            exit();
        } else {
            $message = "Error adding achievement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}

// Process form submission to edit achievement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_achievement'])) {
    $achievement_id = $_POST['achievement_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update achievement
    $stmt = $conn->prepare("UPDATE achievements SET title = ?, description = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $title, $description, $achievement_id);
        if ($stmt->execute()) {
            $message = "Achievement updated successfully";
        } else {
            $message = "Error updating achievement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}

// Process form submission to delete achievement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_achievement'])) {
    $achievement_id = $_POST['achievement_id'];

    // Delete achievement
    $stmt = $conn->prepare("DELETE FROM achievements WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $achievement_id);
        if ($stmt->execute()) {
            $message = "Achievement deleted successfully";
        } else {
            $message = "Error deleting achievement: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
}

// Fetch all achievements
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
<html>
<head>
<link rel="stylesheet" href="homestyle.css">
    <title>Manage Achievements</title>
    <style>
        /* Set a background image */
        body {
            background-image: url('bg.png'); /* Replace with your image URL */
            background-size: cover;
            background-attachment: fixed;
            color: #fff; /* White text for contrast */
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Center the container */
        .container {
            max-width: 800px;
            margin: 20px auto 20px 5%;
            background: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .content-section {
            margin: 20px 0;
        }

        .content-section button {
            margin: 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .content-section button:hover {
            background-color: #45a049;
        }

        /* Styling for form elements */
        form input[type="text"], form textarea, form select {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
        }

        form input[type="submit"] {
            background-color: #008CBA;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        form input[type="submit"]:hover {
            background-color: #007bb5;
        }

        /* Tab section visibility */
        .tab-section {
            display: none;
        }

        .tab-section.active {
            display: block;
        }

        /* Message styling */
        .message {
            background: #4CAF50;
            color: white;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
        }

        /* Table styling for achievements */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
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
    <script>
        function toggleTab(tabId) {
            var tabs = document.querySelectorAll('.tab-section');
            tabs.forEach(function(tab) {
                tab.classList.remove('active');
            });
            document.getElementById(tabId).classList.add('active');
        }
    </script>
</head>
<body>
<div class="button-container">
            <button onclick="location.href='index.php'">Logout</button>
            <button onclick="location.href='ourstoryadmin.php'">Our Story</button>
        <button onclick="location.href='user_approval.php'">user approval</button>
            <button onclick="location.href='classroom.php'">Schedule</button>
        </div>
    <div class="container">
        <div class="content-section">
            <h3>Manage Achievements</h3>
            <div>
                <button id="addAchievementButton" onclick="toggleTab('addAchievement')">Add Achievement</button>
                <button onclick="toggleTab('editAchievement')">Edit Achievement</button>
                <button onclick="toggleTab('deleteAchievement')">Delete Achievement</button>
                <button onclick="toggleTab('viewAchievements')">View Achievements</button>
            </div>
            <div id="achievementTabs">
                <!-- Add Achievement -->
                <div class="tab-section active" id="addAchievement">
                    <h3>Add Achievement</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Title:</label><br>
                        <input type="text" name="title" required><br>
                        <label>Description:</label><br>
                        <textarea name="description" required></textarea><br>
                        <input type="submit" name="add_achievement" value="Add Achievement">
                    </form>
                    <?php if ($message && isset($_POST['add_achievement'])): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Edit Achievement -->
                <div class="tab-section" id="editAchievement">
                    <h3>Edit Achievement</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Select Achievement:</label><br>
                        <select name="achievement_id" required>
                            <?php foreach ($achievements as $achievement): ?>
                                <option value="<?php echo $achievement['id']; ?>"><?php echo $achievement['title']; ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <label>Title:</label><br>
                        <input type="text" name="title" required><br>
                        <label>Description:</label><br>
                        <textarea name="description" required></textarea><br>
                        <input type="submit" name="edit_achievement" value="Edit Achievement">
                    </form>
                    <?php if ($message && isset($_POST['edit_achievement'])): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>

                <!-- Delete Achievement -->
                <div class="tab-section" id="deleteAchievement">
                    <h3>Delete Achievement</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Select Achievement:</label><br>
                        <select name="achievement_id" required>
                            <?php foreach ($achievements as $achievement): ?>
                                <option value="<?php echo $achievement['id']; ?>"><?php echo $achievement['title']; ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <input type="submit" name="delete_achievement" value="Delete Achievement">
                    </form>
                    <?php if ($message && isset($_POST['delete_achievement']))
: ?>
<div class="message"><?php echo $message; ?></div>
<?php endif; ?>
</div>

<!-- View Achievements -->
<div class="tab-section" id="viewAchievements">
<h3>View Achievements</h3>
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
<?php if ($message && empty($_POST['add_achievement']) && empty($_POST['edit_achievement']) && empty($_POST['delete_achievement'])): ?>
<div class="message"><?php echo $message; ?></div>
<?php endif; ?>
</div>
</div>
</div>
</div>
</body>
</html>
