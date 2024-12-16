<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if feedback ID is provided
if (isset($_GET['feedback_id']) && !empty($_GET['feedback_id'])) {
    $feedback_id = intval($_GET['feedback_id']);

    // Delete feedback query
    $deleteQuery = "DELETE FROM feedback WHERE feedback_id = ?";
    $stmt = $conn->prepare($deleteQuery);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $feedback_id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Feedback deleted successfully!');
            window.location.href = '../aview_feedback.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Error deleting feedback. Please try again.');
            window.location.href = '../aview_feedback.php';
        </script>";
    }

    $stmt->close();
} else {
    echo "
    <script>
        alert('Invalid feedback ID. Redirecting to feedback page.');
        window.location.href = '../aview_feedback.php';
    </script>";
}

$conn->close();
?>
