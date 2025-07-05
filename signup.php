<?php
// Include the database connection file
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Check if the email is already registered
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, password, role) 
             VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param('ssss', $username, $email, $password, $role);

        if ($stmt->execute()) {
            // Display alert and redirect to login page
            echo "<script>
                alert('User created successfully!');
                window.location.href = 'login.html';
                </script>";
        } else {
            echo "<script>alert('Error occurred during registration!');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
