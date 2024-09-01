<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-image: url('bg.png');
            background-repeat: no-repeat; 
            background-color: black;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-size: 1600px 800px;
        }

        .button-container {
            display: flex;
            justify-content: space-between; 
            width: 50%; 
        }

        .button-container button {
            padding: 15px 20px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: white;
            color: black;
        }

        
        .button-container button:first-child {
            margin-right: auto; 
        }

        .button-container button:last-child {
            margin-left: auto; 
        }

        .button-containers {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex; 
        }

        .button-containers button {
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

        .button-containers button:hover {
            background-color: #45a049; 
        }
    </style>
</head>
<body>
    <div class="button-container">
        <button class="button" style="margin-right: auto;" onclick="location.href='c1/login.php';">Chat Application</button>
        <button class="button" style="margin-left: auto;" onclick="location.href='transpo/indext.html';">Translator</button>
        <button class="button" style="margin-left: auto;" onclick="location.href='https://vivekspamclassifier.streamlit.app/';">Spam Classifier</button>
    </div>
    <div class="button-containers">
        <button onclick="location.href='index.php'">Logout</button>
        <button onclick="location.href='userinterface.php'">WorkSpace</button>
        <button onclick="location.href='ourstory.php'">Our Story</button>

    </div>
</body>
</html>
