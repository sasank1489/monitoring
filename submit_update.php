<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

require 'db_connection.php';  // Make sure the DB connection file is properly configured

// Fetch form data
$team_number = $_POST['team_number'];
$notes = $_POST['notes'];
$percentage_completed = $_POST['percentage_completed'];
$created_by = $_SESSION['username']; // The user who posted the update
$update_date = date("Y-m-d"); // Current date

// Handle file upload
$target_dir = "uploads/";
$screenshot = basename($_FILES["screenshot"]["name"]);
$target_file = $target_dir . $screenshot;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is an image
$check = getimagesize($_FILES["screenshot"]["tmp_name"]);
if ($check !== false) {
    $uploadOk = 1;
} else {
    echo "File is not an image.";
    $uploadOk = 0;
}

// Move uploaded file to the server
if ($uploadOk && move_uploaded_file($_FILES["screenshot"]["tmp_name"], $target_file)) {
    // Prepare SQL query to insert the update into the database
    $sql = "INSERT INTO daily_updates (team_number, update_date, notes, screenshot, created_by, percentage_completed)
            VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sssssd", $team_number, $update_date, $notes, $target_file, $created_by, $percentage_completed);
        if ($stmt->execute()) {
            echo "Daily update posted successfully!";
            header("Location: stu_dashboard.php"); // Redirect to student dashboard after successful update
            exit();
        } else {
            echo "Error: Could not post the update.";
        }
        $stmt->close();
    }
} else {
    echo "Sorry, there was an error uploading your file.";
}

$conn->close();
?>
