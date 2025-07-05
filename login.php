<?php
// Start session to maintain user login
session_start();

// Database connection
$servername = "localhost";  // Change if using a remote DB server
$username = "root";         // Replace with your MySQL username
$password = "";             // Replace with your MySQL password
$dbname = "projectsync";    // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$passwordInput = $_POST['password']; // Keep the original input password
$role = $_POST['role'];

// Protect from SQL injection
$username = $conn->real_escape_string($username);

// SQL query to retrieve user record based on username and role
$sql = "SELECT * FROM users WHERE username = ? AND role = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('ss', $username, $role); // 'ss' indicates that both parameters are strings
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch user data
    $user = $result->fetch_assoc();

    // Verify the password
    if (password_verify($passwordInput, $user['password'])) {
        // Successful login
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");  // Redirect to dashboard or a relevant page
        if ($role === 'student') {
            header("Location: stu_dashboard.php");  // Redirect to student dashboard
        } else {
            header("Location: fac_dashboard.php");  // Redirect to faculty dashboard
        }
        exit();
    } else {
        // Failed login - wrong password
        echo "Invalid username or password.";
    }
} else {
    // Failed login - user not found
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>
