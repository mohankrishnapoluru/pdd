<?php
include("backend/config.php");

if (!isset($_SESSION['id'])) {
    echo "
    <script>
        alert('You are not logged in. Redirecting to login page.');
        window.location.href = 'index.html';
    </script>
    ";
    exit;
}
?>

<?php
// Fetch user ID (update this to match your session variable)
$user_id = $_SESSION['id']; // Assuming user ID is stored in session

// Fetch appointment history for the logged-in user
$sql = "SELECT appointments.*, doctors.name AS doctor_name 
        FROM appointments 
        JOIN doctors ON appointments.doctor_id = doctors.doctor_id 
        WHERE appointments.user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}
$stmt->bind_param("i", $user_id); // Bind the user ID
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment History</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Set body and html to fill the full screen height */
        html,
        body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f4f4f9;
        }

        /* Header Section */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
        }

        /* Appointment History Section */
        .appointment-history {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            padding: 20px;
            margin: 30px auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 95%;
            max-width: 900px;
            overflow-x: auto;
        }

        


        .appointment-history h3 {
            font-size: 26px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .appointment-history table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .appointment-history th,
        .appointment-history td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        .appointment-history th {
            background-color: #3498db;
            color: white;
        }

        .appointment-history td {
            background-color: #f9f9f9;
        }

        .review-button {
            padding: 6px 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .review-button:hover {
            background-color: #27ae60;
        }

        /* Footer Section */
    </style>
</head>

<body>

    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- Appointment History Section -->
    <section class="appointment-history">
        <h3>Appointment History</h3>
        <table>
            <thead>
                <tr>
                    <th>S No</th>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>
                    <th>Appointment Type</th>
                    <th>Appointment Date and Time</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display appointments for the user
                if ($result->num_rows > 0) {
                    $sno = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $sno++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['doctor_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['patient_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_type']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['appointment_date'] . " " . $row['appointment_time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['remarks']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No appointment history found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>