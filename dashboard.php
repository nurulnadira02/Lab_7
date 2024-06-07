<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Display Dashboard content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome to your Dashboard, <?php echo $_SESSION['name']; ?>!</h2>
    <p><a href="display.php">View User Data</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
