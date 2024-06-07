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

// Fetch all user data
$sql = "SELECT matric, name, role FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    <h3>User Management</h3>
    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr>
                <th>Matric</th>
                <th>Name</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row["matric"]); ?></td>
                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                <td><?php echo htmlspecialchars($row["role"]); ?></td>
                <td>
                    <a href='update.php?matric=<?php echo urlencode($row["matric"]); ?>'>Update</a> |
                    <a href='delete.php?matric=<?php echo urlencode($row["matric"]); ?>' onclick='return confirm("Are you sure you want to delete this user?")'>Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
    <br>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>

<?php
$conn->close();
?>
