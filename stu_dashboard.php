<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';  // Include your database connection file

// Get the team number of the logged-in user
$username = $_SESSION['username'];

// Query to get the team number created by the logged-in user
$sql_team = "SELECT team_number FROM teams WHERE created_by = ?";
$stmt_team = $conn->prepare($sql_team);
$stmt_team->bind_param("s", $username);
$stmt_team->execute();
$result_team = $stmt_team->get_result();

if ($result_team->num_rows > 0) {
    // Fetch the team number
    $team = $result_team->fetch_assoc();
    $team_number = $team['team_number'];

    // Query to fetch daily updates for the team number
    $sql_updates = "SELECT update_date, notes, screenshot FROM daily_updates WHERE team_number = ? ORDER BY update_date DESC";
    $stmt_updates = $conn->prepare($sql_updates);
    $stmt_updates->bind_param("s", $team_number);
    $stmt_updates->execute();
    $result_updates = $stmt_updates->get_result();
} else {
    $team_number = null; // No team found
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
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

        .options {
            display: flex;
            justify-content: space-around;
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

        h3 {
            margin: 20px 0;
        }

        .daily-updates {
            background: rgba(152, 192, 239, 0.06);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(186, 215, 247, 0.18);
        }

        .daily-updates p {
            margin: 5px 0;
        }

        .update {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #c2ccff33;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1);
        }

        .update img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
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
        <h2>Student Dashboard</h2>

        <div class="options">
            <div class="option-btn" onclick="location.href='register_team.php';">Register Team</div>
            <div class="option-btn" onclick="location.href='post_update.php';">Post Update</div>
        </div>

        <h3>Daily Updates</h3>
        <div class="daily-updates">
            <?php
            if ($result_updates->num_rows > 0) {
                while ($update = $result_updates->fetch_assoc()) {
                    echo "<div class='update'>";
                    echo "<strong>Date:</strong> " . $update['update_date'] . "<br>";
                    echo "<strong>Description:</strong> " . $update['notes'] . "<br>";
                    if (!empty($update['screenshot'])) {
                        echo "<strong>Screenshot:</strong><br><img src='" . $update['screenshot'] . "' alt='Update Screenshot'><br>";
                    }
                    echo "</div>";
                }
            } else {
                echo "<p>No updates available for your team.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
