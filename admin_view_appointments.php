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

// Default SQL query to fetch all records
$sql = "SELECT appointments.*, doctors.name AS doctor_name, specializations.specialization_name 
        FROM appointments 
        JOIN doctors ON appointments.doctor_id = doctors.doctor_id
        JOIN specializations ON appointments.specialization_id = specializations.specialization_id";

// Check if a specific date was submitted
if (isset($_POST['appointment_date']) && !empty($_POST['appointment_date'])) {
    $appointment_date = $_POST['appointment_date'];
    $sql .= " WHERE appointments.appointment_date = '$appointment_date'";
}

$result = $conn->query($sql);

// Check if query execution is successful
if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - MediPlus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f8f9fb;
            color: #333;
        }

        /* Header */
        /* header {
            background-color: #1f6e6e;
            color: white;
            padding: 15px 0;
            text-align: center;
            font-size: 24px;
        } */

        /* Main Content */
        .content-main {
            padding: 40px 20px;
            background-color: #f5f5f5;
            min-height: calc(100vh - 200px);
        }

        /* Title */
        h2 {
            color: #1f6e6e;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }

        /* Filter Form */
        .filter-form {
            text-align: center;
            margin-bottom: 30px;
        }

        .filter-form input[type="date"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            max-width: 250px;
        }

        .filter-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #1f6e6e;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .filter-form button:hover {
            background-color: #155959;
        }

        /* Table Container */
        .table-container {
            max-width: 1400px;
            margin: auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px 20px;
            text-align: left;
        }

        th {
            background-color: #D8DBBD;
            color: #1f6e6e;
            font-weight: bold;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .delete-btn {
            background-color: #ff4c4c;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #e03a3a;
        }

        /* Print Button */
        .print-btn {
            background-color: #28a745;
            /* Button color */
            color: white;
            padding: 10px 20px;
            border: center;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            /* Remove underline */
            transition: background-color 0.3s ease;
        }

        .print-btn:hover {
            background-color: #2980b9;
            /* Hover effect */
        }


        /* Form Styling for Status Update */
        .status-update-form {
            display: flex;
            align-items: center;
        }

        .status-update-form select {
            padding: 8px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .status-update-form input {
            padding: 8px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .status-update-form button {
            background-color: #6c63ff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .status-update-form button:hover {
            background-color: #5a54e1;
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <div class="content-main">
        <h2>Appointments</h2>

        <!-- Date Filter Form -->
        <div class="filter-form">
            <form method="POST" action="">
                <input type="date" name="appointment_date"
                    value="<?php echo isset($appointment_date) ? $appointment_date : ''; ?>">
                <button type="submit">Filter by Date</button>
            </form>
        </div>

        <!-- Table of Appointments -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Appointment Type</th>
                        <th>Specialization</th>
                        <th>Doctor Name</th>
                        <th>Taken By User ID</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["appointment_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["patient_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["appointment_date"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["appointment_time"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["appointment_type"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["specialization_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["doctor_name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";

                            // Status and Remarks Form
                            echo "<td>
                                <form method='POST' class='status-update-form' action='backend/update_status_remarks.php'>
                                    <input type='hidden' name='appointment_id' value='" . $row['appointment_id'] . "'>
                                    <select name='status'>
                                        <option value='Confirmed'" . ($row['status'] == 'Confirmed' ? ' selected' : '') . ">Confirmed</option>
                                        <option value='Pending'" . ($row['status'] == 'Pending' ? ' selected' : '') . ">Pending</option>
                                        <option value='Completed'" . ($row['status'] == 'Completed' ? ' selected' : '') . ">Completed</option>
                                    </select>
                                    <input type='text' name='remarks' value='" . htmlspecialchars($row['remarks']) . "' placeholder='Add remarks' />
                                    <button type='submit'>Update</button>
                                </form>
                            </td>";

                            echo "<td><button class='delete-btn' onclick='confirmDelete(" . $row['appointment_id'] . ")'>Delete</button></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='13' style='text-align: center;'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Print Button -->
        <button class="print-btn" onclick="window.print();">Print Appointments</button>


    </div>

    <script>
        function confirmDelete(requestId) {
            if (confirm("Are you sure you want to delete this appointment?")) {
                window.location.href = "backend/delete_appointment.php?id=" + requestId;
            }
        }
    </script>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>