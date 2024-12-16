<?php
include("backend/config.php");

if (!isset($_SESSION['id'])) {
    echo "
    <script>
        alert('You are not logged in. Redirecting to login page.');
        window.location.href = '..index.html';
    </script>
    ";
    exit;
}

// Set the correct timezone
date_default_timezone_set('Asia/Kolkata');

// Get the current date and hour
$current_date = date("Y-m-d H:00:00");
$next_hour = date("Y-m-d H:59:59");

// SQL query to fetch emergency callback requests for the current hour
$sql = "SELECT * FROM callbackrequests WHERE request_time BETWEEN '$current_date' AND '$next_hour'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediPlus Clinic - Admin Home</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body and Layout */
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f5f5f5;
        }

        /* Main Content Section */
        .content-main {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 30px 20px;
            background-color: #e9f5e9;
            flex-grow: 1;
        }

        /* Emergency Callback Section */
        .emergency-callback-section {
            flex: 3;
            margin-right: 20px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .emergency-callback-section h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2f7d68;
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
        }

        .table-container th,
        .table-container td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table-container th {
            background-color: #5fa859;
            color: #fff;
        }

        .table-container tr:hover {
            background-color: #f1fdf1;
        }

        .status-btn {
            background-color: #5fa859;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .status-btn.completed {
            background-color: #4CAF50; /* Green */
        }

        .status-btn:hover {
            opacity: 0.8;
        }

        /* Calendar Section */
        .calendar-section {
            flex: 1;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .calendar-section h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #2f7d68;
        }

        .calendar-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .calendar-controls button {
            background-color: #2f7d68;
            color: #fff;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar-controls button:hover {
            opacity: 0.8;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .calendar-table th,
        .calendar-table td {
            padding: 10px;
            border: 1px solid #ccc;
            width: 14.28%;
        }

        .calendar-day {
            background-color: #f9f9f9;
            cursor: pointer;
        }

        .calendar-day:hover {
            background-color: #e0f7e0;
        }

        .calendar-day.today {
            background-color: #5fa859;
            color: #fff;
            font-weight: bold;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .content-main {
                flex-direction: column;
            }

            .emergency-callback-section,
            .calendar-section {
                margin: 0 0 20px 0;
            }
        }

        @media (max-width: 768px) {
            .table-container table {
                font-size: 12px;
            }

            .calendar-controls button {
                padding: 3px 8px;
            }

            .status-btn {
                padding: 4px 8px;
            }
        }

        @media (max-width: 480px) {
            .calendar-section h2,
            .emergency-callback-section h2 {
                font-size: 18px;
            }

            .calendar-controls button {
                padding: 2px 6px;
                font-size: 12px;
            }

            .status-btn {
                font-size: 12px;
                padding: 3px 6px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <main class="content-main">
        <!-- Emergency Callback Section -->
        <section class="emergency-callback-section">
            <h2>Emergency Callback Requests (This Hour)</h2>
            <div class="table-container">
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile Number</th>
                        <th>Location</th>
                        <th>Request Time</th>
                        <th>Task Status</th>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $status = $row['status'] === 'completed' ? 'completed' : 'pending';
                            $btnClass = $status === 'completed' ? 'status-btn completed' : 'status-btn';

                            // Process the location
                            $location = htmlspecialchars($row['location']);
                            $coordinates = explode(",", $location);
                            if (count($coordinates) === 2) {
                                $lat = $coordinates[0];
                                $lng = $coordinates[1];
                                $locationLink = "<a href='show_directions.php?lat=" . urlencode($lat) . "&lng=" . urlencode($lng) . "' target='_blank'>View Directions</a>";
                            } else {
                                $locationLink = "Invalid Location";
                            }

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['mobile_number']) . "</td>";
                            echo "<td>" . $locationLink . "</td>";
                            echo "<td>" . htmlspecialchars($row['request_time']) . "</td>";
                            echo "<td>
                                    <button id='status-btn-" . $row['id'] . "' class='$btnClass' onclick='updateStatus(" . $row['id'] . ", \"" . ($status === 'pending' ? 'completed' : 'pending') . "\")'>" . ucfirst($status) . "</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' style='text-align: center;'>No emergency requests in this hour</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </section>

        <!-- Calendar Section -->
        <section class="calendar-section">
            <h2>Calendar</h2>
            <div class="calendar-controls">
                <button onclick="changeMonth(-1)">&#8592; Prev</button>
                <span id="month-year"></span>
                <button onclick="changeMonth(1)">Next &#8594;</button>
            </div>
            <table class="calendar-table" id="calendar-table">
                <thead>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thu</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                </thead>
                <tbody id="calendar-body">
                    <!-- Calendar days will be inserted here dynamically -->
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function updateStatus(id, newStatus) {
            const url = `backend/update_status1.php?id=${id}&status=${newStatus}`;
            window.location.href = url;
        }

        const calendarBody = document.getElementById('calendar-body');
        const currentDate = new Date();

        function renderCalendar() {
            const month = currentDate.getMonth();
            const year = currentDate.getFullYear();
            const monthYear = document.getElementById('month-year');
            monthYear.innerHTML = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            calendarBody.innerHTML = '';
            let date = 1;

            for (let i = 0; i < 6; i++) {
                const row = document.createElement('tr');
                for (let j = 0; j < 7; j++) {
                    const cell = document.createElement('td');
                    if (i === 0 && j < firstDay) {
                        row.appendChild(cell);
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        cell.classList.add('calendar-day');
                        if (date === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                            cell.classList.add('today');
                        }
                        cell.innerText = date;
                        row.appendChild(cell);
                        date++;
                    }
                }
                calendarBody.appendChild(row);
            }
        }

        function changeMonth(step) {
            currentDate.setMonth(currentDate.getMonth() + step);
            renderCalendar();
        }

        renderCalendar();
    </script>
</body>
</html>
