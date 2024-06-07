<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login Lab 7</h2>
    <form action="authenticate.php" method="post">
        <label for="matric">Matric:</label><br>
        <input type="text" id="matric" name="matric" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <br>
    <p>Don't have an account? <a href="register.php">Register here</a></p>
    <?php
    // error message to display
    if (isset($_GET['error'])) {
        echo "<p style='color:red'>" . $_GET['error'] . "</p>";
    }
    ?>
</body>
</html>
