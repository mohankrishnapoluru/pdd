<?php
// Include database connection
include("config.php");
require_once 'db_connection.php'; // Update with your connection file path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);

    if (!empty($username)) {
        // Query to check if the username exists
        $query = "SELECT id FROM signup WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "exists"; // Username exists
        } else {
            echo "available"; // Username available
        }

        $stmt->close();
    } else {
        echo "invalid"; // No username provided
    }
} else {
    echo "invalid_request"; // Not a POST request
}

$conn->close();
?>
