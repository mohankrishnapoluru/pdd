<?php
// Include database configuration
include("config.php");

// Get the form data
$appointment_id = $_POST['appointment_id'];
$status = $_POST['status'];
$remarks = $_POST['remarks'];

// Update query
$sql = "UPDATE appointments SET status = ?, remarks = ? WHERE appointment_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("ssi", $status, $remarks, $appointment_id);

if ($stmt->execute()) {
    // Redirect back to the appointment view page with a success message
    header("Location: ../admin_view_appointments.php?update=success");
} else {
    // Handle failure
    echo "Error updating record: " . $stmt->error;
}
?>
