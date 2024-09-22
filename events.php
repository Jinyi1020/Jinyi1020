<?php
// Database connection
$conn = new mysqli('localhost', 'haha', '123', 'haha');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
ccc
// Handle search and sorting
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'event_date';

// Validate sort input to prevent SQL injection
$valid_sorts = ['event_date', 'title', 'location'];
if (!in_array($sort, $valid_sorts)) {
    $sort = 'event_date'; // Default sort
}

// Construct SQL query
$query = "SELECT * FROM events WHERE title LIKE ? OR location LIKE ? ORDER BY $sort";

// Prepare the statement
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters and execute
$search_term = "%" . $search . "%";
$stmt->bind_param("ss", $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events - First Aid Unit Society</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <h1>Upcoming Events</h1>

    <!-- Search Form -->
    <form method="GET" action="events.php">
        <input type="text" name="search" placeholder="Search by event title or location" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <!-- Sort Options -->
    <form method="GET" action="events.php">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort" onchange="this.form.submit()">
            <option value="event_date" <?php if ($sort == 'event_date') echo 'selected'; ?>>Event Date</option>
            <option value="title" <?php if ($sort == 'title') echo 'selected'; ?>>Title</option>
            <option value="location" <?php if ($sort == 'location') echo 'selected'; ?>>Location</option>
        </select>
        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
    </form>

    <!-- Display Events -->
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Location</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['title']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td><?php echo htmlspecialchars($row['event_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No events found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

</body>
</html>
