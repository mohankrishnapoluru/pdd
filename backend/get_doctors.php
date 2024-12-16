<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";  // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['specialization_id'])) {
    $specialization_id = $_GET['specialization_id'];

    // Fetch doctors based on the selected specialization
    $doctor_sql = "SELECT * FROM doctors WHERE specialization_id = ?";
    $stmt = $conn->prepare($doctor_sql);
    $stmt->bind_param("i", $specialization_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $doctors = array();
    while ($doctor = $result->fetch_assoc()) {
        $doctors[] = $doctor;
    }

    // Return the result as a JSON response
    echo json_encode($doctors);
} else {
    echo json_encode([]);
}

// Close the connection
$conn->close();
?>
