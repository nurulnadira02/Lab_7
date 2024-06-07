<?php
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $matric, $name, $password, $role);

// Set parameters and execute
$matric = $_POST['matric'];
$name = $_POST['name'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password storage
$role = $_POST['role'];

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
