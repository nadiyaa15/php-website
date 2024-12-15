<?php
// Start session
session_start();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hardcoded username and password (replace with database later)
    $valid_username = 'cs_ivan';
    $valid_password = 'mantap1227';

    // Retrieve input from form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate username and password
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['username'] = $username; // Set session
        header('Location: dashboard.php'); // Redirect to dashboard
        exit();
    } else {
        $error_message = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengarsipan</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <img src="logo_mandiri_taspen.png" alt="Logo Mandiri Taspen">
        </div>
        <form action="login.php" method="post">
            <h2>Login</h2>
            <?php
            // Display error message if login fails
            if (!empty($error_message)) {
                echo "<p class='error'>$error_message</p>";
            }
            ?>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>
