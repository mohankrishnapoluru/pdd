<?php
// Database connection
include("config.php");

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $mobile_number = $conn->real_escape_string(trim($_POST['mobile_number']));
    $location = $conn->real_escape_string(trim($_POST['location']));  // Get the location
    $user_id = $_SESSION["id"];

    // Check if the required fields are filled
    if (!empty($name) && !empty($mobile_number) && !empty($location)) {
        // Prepare SQL query to insert the data into callbackrequests table
        $sql = "INSERT INTO callbackrequests (name, mobile_number, location, user_id) 
                VALUES ('$name', '$mobile_number', '$location', '$user_id')";

        if ($conn->query($sql) === TRUE) {
            // Redirect or display success message
            echo "<script>alert('Callback request submitted successfully.');</script>";
            echo "<script>window.location.href = '../home.php';</script>";  // Redirect to a home or success page
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Close the connection
$conn->close();
?>
