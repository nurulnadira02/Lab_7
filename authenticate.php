<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";  // Adjust as necessary
$password = "";  // Adjust as necessary
$dbname = "Lab_7";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve user inputs
$matric = $_POST['matric'];
$password = $_POST['password'];

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT password, name FROM users WHERE matric = ?");
$stmt->bind_param("s", $matric);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Bind result variables
    $stmt->bind_result($hashed_password, $name);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Password is correct, set session variables and redirect to dashboard
        $_SESSION['loggedin'] = true;
        $_SESSION['matric'] = $matric;
        $_SESSION['name'] = $name;
        header("Location: dashboard.php");
        exit;
    } else {
        // Password is incorrect, redirect back to login with error
        header("Location: login.php?error=Invalid matric number/password");
        exit;
    }
} else {
    // Matric number not found, redirect back to login with error
    header("Location: login.php?error=Invalid matric number/password");
    exit;
}

$stmt->close();
$conn->close();
?>
