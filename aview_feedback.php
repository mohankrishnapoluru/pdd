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

// SQL query to fetch all feedback records with doctor name by joining feedback and doctors tables
$sql = "
    SELECT feedback.feedback_id, feedback.name, feedback.email, feedback.phone, feedback.message, feedback.feedback_date, feedback.user_id, doctors.name AS doctor_name 
    FROM feedback 
    LEFT JOIN doctors ON feedback.doctor_id = doctors.doctor_id
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - MediPlus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
        }

        /* Header Section */
        .header-main {
            background-color: #28a745;
            padding: 20px;
            color: white;
            text-align: center;
        }

        /* Main Content Section */
        .content-main {
            padding: 30px 20px;
            background-color: #fff;
            min-height: 100vh;
        }

        /* Table Styles */
        h2 {
            color: #1f6e6e;
            text-align: center;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .table-container {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
        }

        th,
        td {
            padding: 12px 20px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #6CBEC7;
            color: white;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .action-btns {
            display: flex;
            gap: 10px;
        }

        /* Footer Section */
        /* For now, we leave the footer commented */
        /* .footer-main { 
            background-color: #28a745;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        } */
    </style>
</head>

<body>

    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <main class="content-main">
        <div class="table-container">
            <h2>User Feedback</h2>
            <table>
                <thead>
                    <tr>
                        <th>Feedback ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Doctor</th>
                        <th>Message</th>
                        <th>Feedback Date</th>
                        <th>User ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if any records were found
                    if ($result->num_rows > 0) {
                        // Fetch each record and display it in the table
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["feedback_id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["phone"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["doctor_name"]) . "</td>";
                            echo "<td>" . nl2br(htmlspecialchars($row["message"])) . "</td>";
                            echo "<td>" . htmlspecialchars($row["feedback_date"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                            echo "<td class='action-btns'>
                                    <button class='delete-btn' onclick='confirmDelete(" . $row["feedback_id"] . ")'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' style='text-align: center;'>No feedback found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer Section -->
    <!--<?php include("adminfooter.php"); ?>-->

    <script>
        function confirmDelete(feedbackId) {
            if (confirm("Are you sure you want to delete this feedback?")) {
                // Redirect to the delete feedback PHP script
                window.location.href = "backend/delete_feedback.php?feedback_id=" + feedbackId;
            }
        
        }
    </script>

</body>

</html>

<?php
// Close the database connection
$conn->close();
?>