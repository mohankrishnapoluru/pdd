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

// Check if delete_id is provided
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize the input

    // Delete all appointments associated with the doctor
    $delete_appointments_sql = "DELETE FROM appointments WHERE doctor_id = $delete_id";
    if ($conn->query($delete_appointments_sql) === TRUE) {
        // After deleting appointments, delete the doctor
        $delete_doctor_sql = "DELETE FROM doctors WHERE doctor_id = $delete_id";
        if ($conn->query($delete_doctor_sql) === TRUE) {
            echo "<script>alert('Doctor and their appointments have been deleted successfully!');</script>";
        } else {
            echo "<script>alert('Failed to delete the doctor.');</script>";
        }
    } else {
        echo "<script>alert('Failed to delete the doctor\'s appointments.');</script>";
    }

    // Redirect to the doctors available page
    header("Location: doctors_available.php");
    exit;
}

// Close the connection
$conn->close();
?>
