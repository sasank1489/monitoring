<?php
session_start();

// Check if user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$created_by = $_SESSION['username']; // Get the logged-in username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post Daily Update</title>
    <style>
        body {
            background-color: #05060f;
            color: #bad6f7;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .update-container {
            background: rgba(152, 192, 239, 0.06);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(186, 215, 247, 0.18);
            text-align: center;
            width: 400px;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            background: linear-gradient(0deg, #bad1f1 30%, #9dc3f7 100%);
            -webkit-background-clip: text;
            color: transparent;
        }
        input[type="file"], input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c2ccff33;
            border-radius: 5px;
            background-color: #121521;
            color: #bad6f7;
        }
        input[type="submit"] {
            background-color: #121521;
            border: 1px solid #c2ccff33;
            color: #bad6f7;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s, box-shadow 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #05060f;
            box-shadow: 0 0 10px #c2ccff91;
        }
    </style>
</head>
<body>
    <div class="update-container">
        <h1>Post Daily Update</h1>
        <form action="submit_update.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="team_number" placeholder="Enter Team Number" required>
            <textarea name="notes" placeholder="Enter Update Notes" required></textarea>
            <input type="file" name="screenshot" accept="image/*" required>
            <input type="number" name="percentage_completed" placeholder="Project Completion (%)" min="0" max="100" step="0.01" required>
            <input type="submit" value="Submit Update">
        </form>
    </div>
</body>
</html>
