<?php
session_start();
include 'db.php'; // Include database connection

$error = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username exists
    $stmt = $conn->prepare("SELECT * FROM Members WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            $_SESSION['userid'] = $user['id'];
            header("Location: update_profile.php"); // Redirect to the profile page
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <div>
        <h1>Login</h1>
        <?php if ($error) { ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form method="POST">
            <p>Username</p>
            <input type="text" name="username" required>
            <p>Password</p>
            <input type="password" name="password" required>
            <input type="submit" value="Login">
        </form>
        <a href="register.php">Don't have an account? Sign up</a>
    </div>
</body>
</html>
