<?php
include 'db.php'; // Include database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $phone = $_POST["phone"];

    // Validate password length
    if (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($password !== $confirmpassword) {
        $error = "Passwords do not match.";
    } else {
        // Check if the username or email already exists
        $stmt = $conn->prepare("SELECT * FROM Members WHERE username=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Username or email is already taken.";
        } else {
            // Hash the password for security
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO Members (username, email, password, phone_number) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $hashedPassword, $phone);
            if ($stmt->execute()) {
                header("Location: login.php?success=Registration successful");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Us</title>
    <link rel="stylesheet" href="css/signup.css">
</head>
<body>
    <div class="loginbox">
        <h1>Join Us</h1>
        <?php if (isset($error)) { ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php } ?>
        <form method="POST">
            <p>Username</p>
            <input type="text" name="username" required>
            <p>Email</p>
            <input type="email" name="email" required>
            <p>Password</p>
            <input type="password" name="password" required>
            <p>Confirm Password</p>
            <input type="password" name="confirmpassword" required>
            <p>Phone Number</p>
            <input type="text" name="phone">
            <input type="submit" value="Join Us">
        </form>
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>
