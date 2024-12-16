<?php
// Database connection settings
$servername = "localhost"; // Database host (usually localhost)
$username = "root"; // Database username (replace with your username)
$password = ""; // Database password (replace with your password)
$dbname = "your_database_name"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
