<?php
include 'db.php'; // Include database connection

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor_name = $_POST["donor_name"];
    $amount = $_POST["amount"];
    $message = $_POST["message"];

    // Validate the donation amount
    if ($amount < 10) {
        $error = "Please enter a valid donation amount of at least RM10.";
    } else {
        // Insert donation details into the database (assuming a Donations table)
        $stmt = $conn->prepare("INSERT INTO Donations (donor_name, amount, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $donor_name, $amount, $message);

        if ($stmt->execute()) {
            $success = "Thank you for your donation!";
        } else {
            $error = "Donation failed. Please try again.";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate to First Aid Unit Society</title>
    <link rel="stylesheet" href="css/donate.css">
</head>
<body>
    <div class="donate-box">
        <h1>Donate Now</h1>
        <?php if ($error) { ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php } elseif ($success) { ?>
            <p style="color:green;"><?php echo htmlspecialchars($success); ?></p>
        <?php } ?>
        <form method="POST">
            <p>Your Name</p>
            <input type="text" name="donor_name" placeholder="Jane" required>
            <p>Donation Amount</p>
            <input type="number" name="amount" placeholder="RM 10" required min="10">
            <p>Message (optional)</p>
            <textarea name="message" placeholder="Your message..."></textarea>
            <input type="submit" value="Donate">
        </form>
        <a href="index.php">Back to Home</a>
    </div>
</body>
</html>
