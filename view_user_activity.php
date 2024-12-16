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
// Check if user ID is passed in the URL
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
} else {
    die("User ID is missing.");
}

// Fetch user information
$user_sql = "SELECT * FROM signup WHERE id = $user_id";
$user_result = $conn->query($user_sql);
$user = $user_result->fetch_assoc();

// Fetch appointment history
$appointments_sql = "SELECT * FROM appointments WHERE user_id = $user_id";
$appointments_result = $conn->query($appointments_sql);

// Fetch callback requests (updated table name)
$callbackrequests_sql = "SELECT * FROM callbackrequests WHERE user_id = $user_id";  // Updated query
$callbackrequests_result = $conn->query($callbackrequests_sql);

// Fetch feedback submissions
$feedback_sql = "SELECT * FROM feedback WHERE user_id = $user_id";
$feedback_result = $conn->query($feedback_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Activity - MediPlus Clinic</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header-main {
            background-color: #f2b8b8;
            padding: 20px;
            text-align: center;
        }

        .header-main h1 {
            color: #1f6e6e;
        }

        .content-main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 1200px;
        }

        h2, h3 {
            color: #1f6e6e;
            margin-bottom: 15px;
        }

        .table-container {
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #6CBEC7;
            color: white;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .back-btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 14px;
            border-radius: 5px;
            margin-top: 30px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            body {
                padding: 10px;
            }

            .header-main h1 {
                font-size: 22px;
            }

            .content-main {
                margin: 10px;
                padding: 15px;
            }

            h2, h3 {
                font-size: 18px;
            }

            table th, table td {
                font-size: 14px;
            }

            .back-btn {
                padding: 8px 12px;
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .header-main h1 {
                font-size: 18px;
            }

            .back-btn {
                padding: 8px 10px;
                font-size: 12px;
            }

            table th, table td {
                font-size: 12px;
                padding: 10px;
            }

            /* Make the table scrollable on smaller screens */
            .table-container {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <div class="content-main">
        <h2>User Activity - <?php echo htmlspecialchars($user["name"]); ?></h2>
        <h3>Username: <?php echo htmlspecialchars($user["username"]); ?></h3>
        <h3>Mobile Number: <?php echo htmlspecialchars($user["mobile"]); ?></h3>
        <h3>User Id: <?php echo htmlspecialchars($user["id"]); ?></h3>

        <!-- Appointment History -->
        <div class="table-container">
            <h3>Appointment History</h3>
            <table>
                <tr>
                    <th>Appointment ID</th>
                    <th>Patient Name</th>
                    <th>Doctor ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
                <?php
                if ($appointments_result->num_rows > 0) {
                    while ($row = $appointments_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["appointment_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["patient_name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["doctor_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["appointment_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["appointment_time"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>No appointment history found</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Callback Requests -->
        <div class="table-container">
            <h3>Callback Requests</h3>
            <table>
                <tr>
                    <th>Request ID</th>
                    <th>Name</th>
                    <th>Mobile Number</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php
                if ($callbackrequests_result->num_rows > 0) {
                    while ($row = $callbackrequests_result->fetch_assoc()) {
                        $status = htmlspecialchars($row["status"]);
                        $statusClass = $status === "completed" ? "completed" : "pending";
                        $location = htmlspecialchars($row["location"]);

                        // Validate the location format (latitude, longitude)
                        $coordinates = explode(",", $location);
                        if (count($coordinates) === 2) {
                            $lat = $coordinates[0];
                            $lng = $coordinates[1];
                            // Create the directions link
                            $locationLink = "<a href='show_directions.php?lat=" . urlencode($lat) . "&lng=" . urlencode($lng) . "' target='_blank'>View Directions</a>";
                        } else {
                            $locationLink = "Invalid Location";
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["mobile_number"]) . "</td>";
                        echo "<td>" . $locationLink . "</td>";
                        echo "<td>" . htmlspecialchars($row["request_time"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>No callback requests found</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Feedback Submissions -->
        <div class="table-container">
            <h3>Feedback Submissions</h3>
            <table>
                <tr>
                    <th>Feedback ID</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Doctor ID</th>
                    <th>Feedback</th>
                </tr>
                <?php
                if ($feedback_result->num_rows > 0) {
                    while ($row = $feedback_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["feedback_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["feedback_date"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["doctor_id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' style='text-align: center;'>No feedback submissions found</td></tr>";
                }
                ?>
            </table>
        </div>

        <!-- Back Button -->
        <a href="manageusers.php" class="back-btn">Back to Users List</a>
    </div>

    <!-- Footer Section -->
    <!--<?php include("adminfooter.php"); ?>-->

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
