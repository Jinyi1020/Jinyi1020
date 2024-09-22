<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - First Aid Unit Society</title>
    <link href="css/style.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Quicksand' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <!-- Header -->
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="aboutus.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="update_profile.php">Update Profile</a></li>
            </ul>
        </nav>
    </header>

    <!-- Contact Section -->
    <div class="contact">
        <h1>Contact Us</h1>
        <p>If you have any questions or need assistance, feel free to reach out to us!</p>
        
        <form method="POST" action="process_contact.php"> <!-- Process form submission -->
            <p>Name:</p>
            <input type="text" name="name" required>
            <p>Email:</p>
            <input type="email" name="email" required>
            <p>Message:</p>
            <textarea name="message" rows="5" required></textarea>
            <input type="submit" value="Send Message">
        </form>

        <div class="contact-info">
            <h2>Our Location</h2>
            <p>123 First Aid Lane, Health City, State, 12345</p>
            <p>Phone: (123) 456-7890</p>
            <p>Email: info@firstaidunitsociety.org</p>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="social">
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
        <p>&copy; 2024 First Aid Unit Society | All Rights Reserved</p>
    </footer>

</body>
</html>
