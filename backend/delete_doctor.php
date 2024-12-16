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

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_appointments_sql = "DELETE FROM appointments WHERE doctor_id = $delete_id";
    $conn->query($delete_appointments_sql);

    $delete_sql = "DELETE FROM doctors WHERE doctor_id = $delete_id";
    $conn->query($delete_sql);
}

$conn->close();

// Redirect back to the main page
header("Location: ../adoctoravailable.php");
exit;
?>
