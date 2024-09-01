<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="preload" href="styles.css" as="style">
    <link rel="stylesheet" href="homestyle.css">
</head>
<body>
    <video autoplay muted id="video-bg">
        <source src="loading.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>

    <div class="button-container">
        <button onclick="location.href='admin.php'">Logout</button>
        <button onclick="location.href='classroom.php'">WorkSpace</button>
        <button onclick="location.href='ourstoryadmin.php'">Our Story</button>
        <button onclick="location.href='user_approval.php'">user approval</button>
</body>
</html>
