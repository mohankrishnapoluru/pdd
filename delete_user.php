<?php
// Include the database configuration file
include("backend/config.php");

// Check if the user ID is provided in the query string
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Sanitize the user ID to prevent SQL injection
    $user_id = intval($_GET['id']);

    // Prepare the SQL query to delete the user record
    $sql = "DELETE FROM signup WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameter
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'manageusers.php';
            </script>";
        } else {
            echo "<script>
                alert('Error deleting user: " . $stmt->error . "');
                window.location.href = 'manageusers.php';
            </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<script>
            alert('Error preparing the statement: " . $conn->error . "');
            window.location.href = 'manageusers.php';
        </script>";
    }
} else {
    echo "<script>
        alert('Invalid request. User ID is missing.');
        window.location.href = 'manageusers.php';
    </script>";
}

// Close the database connection
$conn->close();
?>
