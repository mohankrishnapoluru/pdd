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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Surgery - MediPlus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f4f7fc;
            color: #333;
        }

        /* Container for the form */
        .form-container {
            background-color: #fff;
            width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #6c63ff;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #555;
            margin-bottom: 8px;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-group input[type="file"] {
            font-size: 14px;
        }

        .submit-button {
            background-color: #6c63ff;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #5a54e1;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

    <?php include("adminheader.php"); ?>

    <div class="form-container">
        <h2>Add Surgery</h2>
        <form action="backend/add_surgery.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="surgery_name">Surgery Name</label>
                <input type="text" id="surgery_name" name="surgery_name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="surgery_image">Surgery Image</label>
                <input type="file" id="surgery_image" name="surgery_image" accept="image/*" required>
            </div>
            <button type="submit" class="submit-button">Add Surgery</button>
        </form>
    </div>

</body>
</html>
