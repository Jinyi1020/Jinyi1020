<?php
session_start();
include 'db.php'; // Include database connection

if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$user_id = $_SESSION['userid'];

// Fetch user's profile data
$query = "SELECT * FROM Members WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$error = "";
$success = "";

// Handle form submission for updating profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = isset($_POST['username']) ? $_POST['username'] : '';
    $new_email = isset($_POST['email']) ? $_POST['email'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

    // Update username
    if (!empty($new_username)) {
        $update_query = "UPDATE Members SET username = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $new_username, $user_id);
        if ($update_stmt->execute()) {
            $success = "Username updated successfully!";
        } else {
            $error = "Failed to update username: " . $conn->error;
        }
    }

    // Update email
    if (!empty($new_email)) {
        $update_query = "UPDATE Members SET email = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $new_email, $user_id);
        if ($update_stmt->execute()) {
            $success = "Email updated successfully!";
        } else {
            $error = "Failed to update email: " . $conn->error;
        }
    }

    // Update phone number
    if (!empty($phone)) {
        $update_query = "UPDATE Members SET phone_number = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("si", $phone, $user_id);
        if ($update_stmt->execute()) {
            $success = "Phone number updated successfully!";
        } else {
            $error = "Failed to update phone number: " . $conn->error;
        }
    }

    // Update password
    if (!empty($new_password)) {
        if (strlen($new_password) >= 8) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE Members SET password = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("si", $hashed_password, $user_id);
            if ($update_stmt->execute()) {
                $success = "Password updated successfully!";
            } else {
                $error = "Failed to update password: " . $conn->error;
            }
        } else {
            $error = "Password must be at least 8 characters long.";
        }
    }
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Update Profile</title>
</head>
<body>
    <div>
        <h1>Update Profile</h1>
        <?php if ($error) { ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php } elseif ($success) { ?>
            <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
        <?php } ?>
        <form method="POST">
            <p>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required></p>
            <p>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required></p>
            <p>Change Password: <input type="password" name="new_password" placeholder="New Password"></p>
            <p>Phone Number: <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone_number']); ?>" placeholder="Enter Phone Number"></p>
            <input type="submit" value="Update Profile">
        </form>
        <br>
        <a href="index.php"><button>Back to Home</button></a> <!-- Back to Home button -->
    </div>
</body>
</html>
