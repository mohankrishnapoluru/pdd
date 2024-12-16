<?php
// Database connection
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

// Default SQL query to fetch all records from signup table
$sql = "SELECT * FROM signup";

// Check if a specific role filter was submitted
if (isset($_POST['user_role']) && !empty($_POST['user_role'])) {
    $user_role = $_POST['user_role'];
    $sql .= " WHERE role = '$user_role'";
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
    <title>View Users - MediPlus Clinic</title>
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

        /* Header Section */
        .header-main {
            background-color: #28a745;
            padding: 20px;
            text-align: center;
            color: white;
        }

        /* Main Content */
        .content-main {
            padding: 30px 20px;
            background-color: #f5f5f5;
            min-height: 100vh;
            margin-bottom: 40px;
        }

        /* Title */
        h2 {
            color: #1f6e6e;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
        }

        /* Table Container */
        .table-container {
            max-width: 1200px;
            margin: 30px auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 15px 20px;
            text-align: left;
        }

        th {
            background-color: #f1f1f1;
            color: #1f6e6e;
            font-weight: bold;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #fafafa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .action-btns a {
            background-color: #007bff;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .action-btns a:hover {
            background-color: #0056b3;
        }

        .filter-form {
            text-align: center;
            margin-bottom: 20px;
        }

        .filter-form select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .filter-form button:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

    </style>
</head>

<body>

    <!-- Header Section -->
    <?php include("adminheader.php"); ?>

    <!-- Main Content Section -->
    <div class="content-main">
        <h2>View Users</h2>

        <!-- Role Filter Form -->
        <!-- <div class="filter-form">
            <form method="POST" action="">
                <select name="user_role">
                    <option value="">Select Role</option>
                    <option value="Admin" <?php echo isset($user_role) && $user_role == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                    <option value="User" <?php echo isset($user_role) && $user_role == 'User' ? 'selected' : ''; ?>>User</option>
                    <option value="Doctor" <?php echo isset($user_role) && $user_role == 'Doctor' ? 'selected' : ''; ?>>Doctor</option>
                </select>
                <button type="submit">Filter</button>
            </form>
        </div> -->

        <!-- User Data Table -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if any records were found
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["username"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["mobile"]) . "</td>";
                            echo "<td class='action-btns'>
                                    <a href='view_user_activity.php?user_id=" . $row["id"] . "'>View</a> 
                                    <button class='delete-btn' onclick='confirmDelete(" . $row["id"] . ")'>Delete</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>No records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
                window.location.href = "delete_user.php?id=" + userId;
            }
        }
    </script>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
