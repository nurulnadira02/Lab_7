<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

$matric = $_GET['matric'];

// Delete user data
$stmt = $conn->prepare("DELETE FROM users WHERE matric=?");
$stmt->bind_param("s", $matric);

if ($stmt->execute()) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$conn->close();

header("Location: display.php");
exit;
?>
