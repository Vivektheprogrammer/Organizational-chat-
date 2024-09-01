<?php
session_start();
include("connect.php");

// Checking if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin.php");
    exit();
}

// Fetching user emails and ids for the checkbox list and delete options
$user_data = [];
$user_query = "SELECT id, email FROM users";
$user_result = $conn->query($user_query);
if ($user_result->num_rows > 0) {
    while ($row = $user_result->fetch_assoc()) {
        $user_data[] = ['id' => $row['id'], 'email' => $row['email']];
    }
}

// Fetching all content titles and user ids
$content_data = [];
$content_query = "SELECT c.id, c.title, c.user_id, u.email FROM content c JOIN users u ON c.user_id = u.id";
$content_result = $conn->query($content_query);
if ($content_result->num_rows > 0) {
    while ($row = $content_result->fetch_assoc()) {
        $content_data[] = ['id' => $row['id'], 'title' => $row['title'], 'user_id' => $row['user_id'], 'email' => $row['email']];
    }
}

// Initialize message variable
$message = '';

// Process form submission to add content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_content'])) {
    $title = $_POST['title'];
    $type = $_POST['type'];
    $selected_users = $_POST['users'];
    $content_data = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $filetype = $_FILES['file']['type'];

        $upload_directory = "uploads/";
        $upload_path = $upload_directory . $filename;

        if (move_uploaded_file($tmp_name, $upload_path)) {
            $content_data = $upload_path;
        } else {
            $message = "Error uploading file";
        }
    } else {
        $content_data = $_POST['content_data'];
    }

    if ($content_data) {
        $success = true;
        foreach ($selected_users as $user_id) {
            // Insert content
            $stmt = $conn->prepare("INSERT INTO content (title, type, content_data, user_id) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $title, $type, $content_data, $user_id);
            if (!$stmt->execute()) {
                $message = "Error: " . $stmt->error;
                $success = false;
                break;
            }
            $stmt->close();
        }
        if ($success) {
            $message = "New content added successfully";
        }
    } else {
        $message = "Please provide content data.";
    }
}

// Process form submission to delete content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_content'])) {
    $content_id = $_POST['content_id'];

    $stmt = $conn->prepare("DELETE FROM content WHERE id = ?");
    $stmt->bind_param("i", $content_id);
    if ($stmt->execute()) {
        $message = "Content deleted successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Process form submission to view content
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_content'])) {
    if (isset($_POST['view_users'])) {
        $selected_view_users = $_POST['view_users'];
        $placeholders = implode(',', array_fill(0, count($selected_view_users), '?'));
        $types = str_repeat('i', count($selected_view_users));

        // Fetch content along with user email and id using JOIN
        $stmt = $conn->prepare("SELECT c.id, c.title, c.type, c.content_data, c.user_id, u.email 
                                FROM content c
                                JOIN users u ON c.user_id = u.id
                                WHERE c.user_id IN ($placeholders)");
        if ($stmt) {
            $stmt->bind_param($types, ...$selected_view_users);
            $stmt->execute();
            $result = $stmt->get_result();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="classroom.css">
    <link rel="stylesheet" href="homestyle.css">
    <style>
        .tab-section {
            display: none;
        }
        .content-section {
            margin: 20px 0;
        }
        .content-section button {
            margin: 5px;
        }
        .view-content-container .content-item {
            border: 1px solid #ddd;
            margin: 10px 0;
            padding: 10px;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
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

    </style>
    <script>
        function toggleSection(sectionId) {
            var sections = document.getElementsByClassName('content-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }

        function toggleTab(tabId) {
            var tabs = document.getElementById('scheduleTabs').getElementsByClassName('tab-section');
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = 'none';
            }
            document.getElementById(tabId).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="menu">
            <ul>
                <li><a href="#" onclick="toggleSection('schedule')">Schedule</a></li>
                <li><a href="achievementadmin.php">Achievements</a></li>
            </ul>
        </div>
        <div class="button-container">
            <button onclick="location.href='index.php'">Logout</button>
            <button onclick="location.href='ourstoryadmin.php'">Our Story</button>
        <button onclick="location.href='user_approval.php'">user approval</button>
        </div>

        <!-- Create Schedule Section -->
        <div class="content-section" id="schedule" style="display: block;">
            <div class="button-section" >
                <button id="addContentButton" onclick="toggleTab('addSchedule')">Add Content</button>
                <button id="viewContentButton" onclick="toggleTab('viewSchedule')">View Content</button>
                <button id="editContentButton" onclick="toggleTab('editSchedule')">Delete Content</button>
            </div>
            <div id="scheduleTabs">
                <!-- Add Content -->
                <div class="tab-section" id="addSchedule" style="display: block;">
                    <h3>Add Content</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                        <label>Title:</label><br>
                        <input type="text" name="title" required><br>
                        <label>Type:</label><br>
                        <select name="type" required>
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="image">Image</option>
                        </select><br>
                        <label>Users:</label><br>
                        <?php foreach ($user_data as $user): ?>
                            <input type="checkbox" name="users[]" value="<?php echo $user['id']; ?>"> <?php echo $user['email']; ?><br>
                        <?php endforeach; ?>
                        <label>File:</label><br>
                        <input type="file" name="file"><br>
                        <label>Content:</label><br>
                        <textarea name="content_data"></textarea><br>
                        <input type="submit" name="add_content" value="Add Content">
                    </form>
                    <?php if ($message && isset($_POST['add_content'])): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>

                <!-- View Content -->
                <div class="tab-section" id="viewSchedule">
                    <h3>View Content</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Select Users:</label><br>
                        <?php foreach ($user_data as $user): ?>
                            <input type="checkbox" name="view_users[]" value="<?php echo $user['id']; ?>"> <?php echo $user['email']; ?><br>
                        <?php endforeach; ?>
                        <input type="submit" name="view_content" value="View Content">
                    </form>
                    <?php if ($message && isset($_POST['view_content'])): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <div class="view-content-container">
                        <?php if (isset($result)): ?>
                            <?php if ($result->num_rows > 0): ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <div class="content-item">
                                        <h4><?php echo $row['title']; ?></h4>
                                        <p>Type: <?php echo $row['type']; ?></p>
                                        <p>User: <?php echo $row['email']; ?></p>
                                        <?php if ($row['type'] == 'text'): ?>
                                            <p><?php echo $row['content_data']; ?></p>
                                        <?php elseif ($row['type'] == 'video' || $row['type'] == 'image'): ?>
                                            <p><a href="<?php echo $row['content_data']; ?>" target="_blank">View File</a></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="message">No content for the selected user(s).</div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Edit Content -->
                <div class="tab-section" id="editSchedule">
                    <h3>Delete Content</h3>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <label>Select User:</label><br>
                        <select name="user_id" required>
                            <?php foreach ($user_data as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['email']; ?></option>
                            <?php endforeach; ?>
                        </select><br>
                        <label>Select Content Title:</label><br>
                        <select name="content_id" required>
                            <?php foreach ($content_data as $content): ?>
                                <option value="<?php echo $content['id']; ?>" data-user-id="<?php echo $content['user_id']; ?>"><?php echo $content['title']; ?> (<?php echo $content['email']; ?>)</option>
                            <?php endforeach; ?>
                        </select><br>
                        <input type="submit" name="delete_content" value="Delete Content">
                    </form>
                    <?php if ($message && isset($_POST['delete_content'])): ?>
                        <div class="message"><?php echo $message; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

