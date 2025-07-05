<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'faculty') {
    header("Location: login.html");
    exit();
}

// Faculty dashboard logic goes here
$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            background-color: #05060f;
            color: #bad6f7;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #121521;
            padding: 20px;
            color: #bad6f7;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header h2 {
            margin: 0;
        }

        .logout-btn {
            background-color: #121521;
            border: 1px solid #c2ccff33;
            color: #bad6f7;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .logout-btn:hover {
            background-color: #05060f;
            box-shadow: 0 0 10px #c2ccff91;
        }

        .container {
            padding: 40px;
        }

        h1 {
            background: linear-gradient(0deg, #bad1f1 30%, #9dc3f7 100%);
            -webkit-background-clip: text;
            color: transparent;
            font-size: 28px;
        }

        p {
            font-size: 18px;
            margin: 20px 0;
        }

        .option-btn {
            background-color: #121521;
            border: 1px solid #c2ccff33;
            color: #bad6f7;
            padding: 20px;
            width: 200px;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            margin: 20px;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .option-btn:hover {
            background-color: #05060f;
            box-shadow: 0 0 10px #c2ccff91;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <form action="logout.php" method="POST">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>

    <div class="container">
        <h1>Faculty Dashboard</h1>
        <p>This is the faculty dashboard where you can manage and view updates.</p>
        
        <!-- Example Options, you can add more -->
        <div class="option-btn" onclick="location.href='review_teams.php';">Review Teams</div>
        <div class="option-btn" onclick="location.href='review_updates.php';">Review Updates</div>
    </div>
</body>
</html>
