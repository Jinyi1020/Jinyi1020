<?php
$servername = "localhost";
$username = "haha";
$password = "123";
$dbname = "haha";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
