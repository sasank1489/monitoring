<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Team</title>
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

        .register-container {
            background: rgba(152, 192, 239, 0.06);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(186, 215, 247, 0.18);
            text-align: center;
            width: 350px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            background: linear-gradient(0deg, #bad1f1 30%, #9dc3f7 100%);
            -webkit-background-clip: text;
            color: transparent;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #c2ccff33;
            border-radius: 5px;
            background-color: #121521;
            color: #bad6f7;
        }

        input[type="submit"]:hover {
            background-color: #05060f;
            box-shadow: 0 0 10px #c2ccff91;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h1>Register Your Team</h1>
    <form action="submit.php" method="POST">
        <label for="team_number">Team Number:</label>
        <input type="text" name="team_number" required><br><br>

        <label for="team_leader">Team Leader:</label>
        <input type="text" name="team_leader" required><br><br>

        <label for="member1">Member 1:</label>
        <input type="text" name="member1"><br><br>

        <label for="member2">Member 2:</label>
        <input type="text" name="member2"><br><br>

        <label for="member3">Member 3:</label>
        <input type="text" name="member3"><br><br>

        <input type="submit" value="Register Team">
    </form>
</div>

</body>
</html>
