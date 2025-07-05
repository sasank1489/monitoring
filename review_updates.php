<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'faculty') {
    header("Location: login.html");
    exit();
}

require 'db_connection.php';  // Ensure you have the correct DB connection file

// Fetch all daily updates from the database
$sql = "SELECT team_number, update_date, notes, screenshot, created_by, percentage_completed FROM daily_updates";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Updates</title>
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

        .logout-btn, .back-btn {
            background-color: #121521;
            border: 1px solid #c2ccff33;
            color: #bad6f7;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s, box-shadow 0.3s;
        }

        .logout-btn:hover, .back-btn:hover {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #bad6f7;
        }

        table, th, td {
            border: 1px solid #c2ccff33;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #121521;
        }

        tr:nth-child(even) {
            background-color: #1b1e2a;
        }

        tr:hover {
            background-color: #333644;
        }

        .top-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .screenshot {
            max-width: 150px; /* Adjust this to fit your design */
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Review Updates</h2>
        <form action="logout.php" method="POST">
            <button class="logout-btn" type="submit">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="top-actions">
            <button class="back-btn" onclick="location.href='fac_dashboard.php';">Back to Dashboard</button>
        </div>

        <h1>Daily Updates</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Team Number</th>
                        <th>Update Date</th>
                        <th>Notes</th>
                        <th>Screenshot</th>
                        <th>Submitted By</th>
                        <th>Percentage Completed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['team_number']; ?></td>
                            <td><?php echo $row['update_date']; ?></td>
                            <td><?php echo $row['notes']; ?></td>
                            <td>
                                <img src="<?php echo $row['screenshot']; ?>" alt="Screenshot" class="screenshot">
                            </td>
                            <td><?php echo $row['created_by']; ?></td>
                            <td><?php echo $row['percentage_completed'] ? $row['percentage_completed'] . '%' : 'N/A'; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No updates have been submitted yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
