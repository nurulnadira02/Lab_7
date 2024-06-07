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

$original_matric = $_GET['matric'];  // Original matric to identify the user

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update user data
    $new_matric = $_POST['matric'];
    $new_name = $_POST['name'];
    $new_role = $_POST['role'];

    // Check if the matric number is being changed and if the new matric number already exists
    if ($new_matric != $original_matric) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
        $stmt->bind_param("s", $new_matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "The new matric number already exists. Please choose a different one.";
            $stmt->close();
        } else {
            // If matric number is not taken, proceed with update
            $stmt->close();
            $stmt = $conn->prepare("UPDATE users SET matric=?, name=?, role=? WHERE matric=?");
            $stmt->bind_param("ssss", $new_matric, $new_name, $new_role, $original_matric);
            if ($stmt->execute()) {
                echo "Record updated successfully";
                $_SESSION['matric'] = $new_matric; // Update session if needed
                header("Location: display.php");
                exit;
            } else {
                echo "Error updating record: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        // If the matric number is the same, just update other fields
        $stmt = $conn->prepare("UPDATE users SET name=?, role=? WHERE matric=?");
        $stmt->bind_param("sss", $new_name, $new_role, $original_matric);
        if ($stmt->execute()) {
            echo "Record updated successfully";
            header("Location: display.php");
            exit;
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
    exit;
}

// Fetch existing data
$stmt = $conn->prepare("SELECT matric, name, role FROM users WHERE matric=?");
$stmt->bind_param("s", $original_matric);
$stmt->execute();
$stmt->bind_result($matric, $name, $role);
$stmt->fetch();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User</title>
</head>
<body>
    <h2>Update User Information</h2>
    <form action="" method="post">
        <label for="matric">Matric:</label>
        <input type="text" id="matric" name="matric" value="<?php echo htmlspecialchars($matric); ?>" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="student" <?php if ($role == 'student') echo 'selected'; ?>>Student</option>
            <option value="lecturer" <?php if ($role == 'lecturer') echo 'selected'; ?>>Lecturer</option>
        </select><br><br>

        <button type="submit">Update</button>
        <a href="display.php" style="text-decoration: none;">
            <button type="button">Cancel</button>
        </a>
    </form>
    <p><a href="display.php">Back to User List</a></p>
</body>
</html>
