<?php
include("backend/config.php");

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo "
    <script>
        alert('You are not logged in. Redirecting to login page.');
        window.location.href = 'index.html';
    </script>
    ";
    exit;
}

// Fetch all surgery details from the database
$sql = "SELECT * FROM surgeries ORDER BY created_at DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching surgeries: " . $conn->error);
}

// Handle deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM surgeries WHERE surgery_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "
        <script>
            alert('Surgery deleted successfully!');
            window.location.href = 'adminsurgery.php';
        </script>
        ";
    } else {
        echo "Error deleting surgery: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Surgeries</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f7f8fa;
            color: #444;
        }

        .main-content {
            padding: 20px;
            text-align: center;
        }

        h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .surgery {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            background-color: #ffffff;
            padding: 15px;
            margin: 10px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .surgery:hover {
            transform: scale(1.02);
        }

        .surgery img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 15px;
        }

        .surgery-content {
            flex: 1;
            text-align: left;
        }

        .surgery-content h4 {
            font-size: 18px;
            color: #333;
            margin-bottom: 8px;
        }

        .surgery-content p {
            font-size: 14px;
            color: #777;
            line-height: 1.5;
        }

        .btn {
            background-color: #6c63ff;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            margin: 10px auto;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #5a53e1;
        }

        .delete-btn {
            background-color: #ff4747;
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .delete-btn:hover {
            background-color: #e04141;
        }

        .no-surgeries {
            font-size: 16px;
            color: #888;
            margin: 20px;
        }

        @media (max-width: 768px) {
            .surgery {
                flex-direction: column;
                text-align: center;
            }

            .surgery img {
                margin-bottom: 10px;
                margin-right: 0;
            }

            .surgery-content {
                text-align: center;
            }

            .btn {
                font-size: 14px;
                padding: 8px 12px;
            }

            .delete-btn {
                font-size: 12px;
                padding: 6px 10px;
            }
        }
    </style>
</head>
<body>

    <?php include("adminheader.php"); ?>

    <div class="main-content">
        <h2>Uploaded Surgeries</h2>
        <a href="admin_add_surgery.php" class="btn">Add New Surgery</a>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="surgery">
                    <img src="uploads/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['surgery_name']) ?>">
                    <div class="surgery-content">
                        <h4><?= htmlspecialchars($row['surgery_name']) ?></h4>
                        <p><?= htmlspecialchars($row['description']) ?></p>
                    </div>
                    <a href="?delete_id=<?= $row['surgery_id'] ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this surgery?')">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-surgeries">No surgeries found.</p>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?>
