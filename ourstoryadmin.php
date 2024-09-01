<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story</title>
    <style>
        body {
            background-color: black;
            background-image: url('OUR.png');
            background-size: 1600px 800px; 
            background-position: center;
            background-repeat: no-repeat; 
            margin: 0; 
            padding: 0; 
            height: 100vh; 
            font-family: Arial, sans-serif; 
        
        .button-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        
        .button-container button {
            margin-left: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button-container button:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='index.php'">Logout</button>
        <button onclick="location.href='classroom.php'">WorkSpace</button>
        <button onclick="location.href='user_approval.php'">user approval</button>
    </div>
</body>
</html>
