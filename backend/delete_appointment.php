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

// Check if 'id' parameter is set
if (isset($_GET['id'])) {
    $appointment_id = intval($_GET['id']);

    // SQL query to delete the appointment
    $sql = "DELETE FROM appointments WHERE appointment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        // Redirect back to the appointments page with a success message
        header("Location: ../admin_view_appointments.php?message=Record+Deleted+Successfully");
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No record ID specified.";
}

$conn->close();
?>
