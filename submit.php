<?php
session_start();

// Check if the user is logged in and is a student
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';  // Ensure db_connection.php is correctly set up

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $team_number = $_POST['team_number'];
    $team_leader = $_POST['team_leader'];
    $member1 = !empty($_POST['member1']) ? $_POST['member1'] : NULL;
    $member2 = !empty($_POST['member2']) ? $_POST['member2'] : NULL;
    $member3 = !empty($_POST['member3']) ? $_POST['member3'] : NULL;
    $created_by = $_SESSION['username'];  // Username of the student who created the team

    // Check if the user has already registered a team
    $check_sql = "SELECT * FROM teams WHERE created_by = ?";
    if ($stmt_check = $conn->prepare($check_sql)) {
        $stmt_check->bind_param("s", $created_by);
        $stmt_check->execute();
        $result = $stmt_check->get_result();
        
        if ($result->num_rows > 0) {
            // User already registered a team
            echo "<script>alert('You have already registered a team.'); window.location.href = 'stu_dashboard.php';</script>";
            exit();
        }
        
        $stmt_check->close();
    }

    // Prepare SQL query to insert the new team
    $sql = "INSERT INTO teams (team_number, team_leader, member1, member2, member3, created_by) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute the query
        $stmt->bind_param("ssssss", $team_number, $team_leader, $member1, $member2, $member3, $created_by);
        
        if ($stmt->execute()) {
            // Success message and redirection
            echo "<script>alert('Team registered successfully!'); window.location.href = 'stu_dashboard.php';</script>";
        } else {
            // Error message and redirection
            echo "<script>alert('Error: Could not register team.'); window.location.href = 'register_team.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Error: Could not prepare SQL statement.";
    }

    // Close the database connection
    $conn->close();
}
?>
