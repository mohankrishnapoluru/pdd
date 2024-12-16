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

// SQL query to fetch all records from the callbackrequests table
$sql = "SELECT * FROM callbackrequests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Callback Requests - MediPlus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        html, body {
            height: 100%;
            background-color: #f1f1f1;
        }

        .content-main {
            padding: 20px;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        h2 {
            color: #2d6a4f;
            margin-bottom: 20px;
            text-align: center;
            font-size: 2em;
        }

        .table-container {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            min-width: 800px; /* Ensures table scrolls on smaller screens */
        }

        th, td {
            padding: 10px 15px;
            text-align: left;
            font-size: 0.9rem;
            white-space: nowrap; /* Prevent text wrapping */
        }

        th {
            background-color: #4caf50;
            color: white;
            font-weight: bold;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1fdf1;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .status-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .status-btn.pending {
            background-color: #ffae42;
            color: white;
        }

        .status-btn.completed {
            background-color: #4CAF50;
            color: white;
        }

        .delete-btn {
            padding: 6px 12px;
            background-color: #e74c3c;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 0.8rem;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .location-link {
            color: #007bff;
            text-decoration: none;
        }

        .location-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            th, td {
                font-size: 0.8rem;
                padding: 8px;
            }

            .status-btn, .delete-btn {
                font-size: 0.7rem;
                padding: 4px 8px;
            }

            h2 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            table {
                display: block;
                overflow-x: auto;
            }

            th, td {
                font-size: 0.75rem;
                padding: 6px;
            }

            .status-btn, .delete-btn {
                font-size: 0.65rem;
                padding: 3px 6px;
            }

            h2 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <main class="content-main">
        <div class="table-container">
            <h2>Callback Requests</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th>Request Date</th>
                        <th>Requested ID</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $status = htmlspecialchars($row["status"]);
                        $statusClass = $status === "completed" ? "completed" : "pending";
                        $location = htmlspecialchars($row["location"]);

                        $coordinates = explode(",", $location);
                        if (count($coordinates) === 2) {
                            $lat = $coordinates[0];
                            $lng = $coordinates[1];
                            $locationLink = "<a class='location-link' href='show_directions.php?lat=" . urlencode($lat) . "&lng=" . urlencode($lng) . "' target='_blank'>View Directions</a>";
                        } else {
                            $locationLink = "Invalid Location";
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["mobile_number"]) . "</td>";
                        echo "<td>" . $locationLink . "</td>";
                        echo "<td>" . htmlspecialchars($row["request_time"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["user_id"]) . "</td>";
                        echo "<td>
                            <button class='status-btn $statusClass' onclick='updateStatus(" . $row["id"] . ", \"" . $status . "\")'>" . ucfirst($status) . "</button>
                        </td>";
                        echo "<td>
                            <button class='delete-btn' onclick='confirmDelete(" . $row["id"] . ")'>Delete</button>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' style='text-align: center;'>No records found</td></tr>";
                }

                $conn->close();
                ?>

                </tbody>
            </table>
        </div>
    </main>

    <script>
        function updateStatus(requestId, currentStatus) {
            const newStatus = currentStatus === "completed" ? "pending" : "completed";
            if (confirm(`Are you sure you want to mark this request as ${newStatus}?`)) {
                window.location.href = `backend/update_status2.php?id=${requestId}&status=${newStatus}`;
            }
        }

        function confirmDelete(requestId) {
            if (confirm("Are you sure you want to delete this request?")) {
                window.location.href = `backend/delete_callback.php?id=${requestId}`;
            }
        }
    </script>

</body>
</html>
            