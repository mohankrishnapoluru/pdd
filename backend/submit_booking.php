<?php
include("config.php");
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $appointment_date = $_POST['date'];
    $appointment_time = $_POST['time'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $appointment_type = $_POST['appointment_type'];
    $specialization_id = $_POST['specializations'];
    $doctor_id = $_POST['doctor'];
    $user_id = $_SESSION["id"];

    $sql = "INSERT INTO appointments (patient_name, user_id, appointment_date, appointment_time, phone, address, appointment_type, specialization_id, doctor_id)
            VALUES ('$name',$user_id, '$appointment_date', '$appointment_time', '$phone', '$address', '$appointment_type', $specialization_id, $doctor_id)";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Appointment Booking request submitted successfully.');</script>";
        echo "<script>window.location.href = '../booking.php';</script>";
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Fetch specializations and doctors for dropdowns
$specializations_sql = "SELECT * FROM specializations";
$specializations_result = $conn->query($specializations_sql);

$doctor_sql = "SELECT * FROM doctors";
$doctor_result = $conn->query($doctor_sql);

$conn->close();
?>
