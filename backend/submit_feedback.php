<?php
// Include the database connection settings
include("config.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $doctor_id = (int)$_POST['doctor'];
    $message = $conn->real_escape_string($_POST['message']);
    $user_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

    // Validate doctor ID
    if ($doctor_id <= 0) {
        die("Error: Invalid doctor selected.");
    }

    // Check if doctor exists
    $checkDoctorQuery = "SELECT * FROM doctors WHERE doctor_id = $doctor_id";
    $checkDoctorResult = $conn->query($checkDoctorQuery);

    if ($checkDoctorResult->num_rows == 0) {
        die("Error: Doctor ID does not exist in the database.");
    }

    // Insert feedback
    $sql = "INSERT INTO feedback (name, email, phone, doctor_id, message, user_id) 
            VALUES ('$name', '$email', '$phone', $doctor_id, '$message', $user_id)";

    if ($conn->query($sql) === TRUE) {
        
        echo "<script>alert('Feedback submitted successfully.');</script>";
        echo "<script>window.location.href = '../home.php';</script>";  // Redirect to a home or success page
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>



