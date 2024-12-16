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
// Database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch specialization options for the dropdown
$specializations = [];
$sql = "SELECT specialization_id, specialization_name FROM specializations";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $specializations[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor - MediPlus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body */
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }

        /* Main Content */
        .content-main {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Form Container */
        .form-container {
            background-color: #ffffff;
            width: 450px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .form-container:hover {
            transform: scale(1.05);
        }

        /* Header */
        .form-container h2 {
            margin-bottom: 20px;
            color: #6c63ff;
            font-size: 24px;
        }

        /* Doctor Image Section */
        .doctor-image {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .doctor-image img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #f1f1f1;
        }

        .doctor-image label {
            margin-top: 10px;
            font-size: 14px;
            color: #6c63ff;
            cursor: pointer;
            text-decoration: underline;
        }

        .doctor-image input[type="file"] {
            display: none;
        }

        /* Form Fields */
        .form-group {
            margin-bottom: 20px;
            text-align: left;
            width: 100%;
        }

        .form-group label {
            display: block;
            font-size: 16px;
            color: #444;
            margin-bottom: 8px;
        }

        .form-group input[type="text"],
        .form-group input[type="tel"],
        .form-group textarea,
        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            color: #333;
            transition: border-color 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="tel"]:focus,
        .form-group textarea:focus,
        select:focus {
            border-color: #6c63ff;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Submit Button */
        .submit-button {
            background-color: #6c63ff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-button:hover {
            background-color: #5a53e2;
        }

        /* Footer Section */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            text-align: center;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- Display success message if redirected after form submission -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <script>
            alert("Doctor added successfully!");
        </script>
    <?php endif; ?>

    <!-- Header Section -->
    <?php include('adminheader.php'); ?>

    <!-- Main Content Section -->
    <main class="content-main">
        <div class="form-container">
            <!-- Form Fields -->
            <h2>Add Doctor</h2>
            <form action="backend/add_doctor.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="tel" name="phone_number" required>
                </div>
                <div class="form-group">
                    <label for="specialization">Specialization:</label>
                    <select id="specialization" name="specialization" required>
                        <?php foreach ($specializations as $spec): ?>
                            <option value="<?= $spec['specialization_id'] ?>">
                                <?= htmlspecialchars($spec['specialization_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="doctor_image">Select a file</label>
                    <input type="file" id="doctor_image" name="doctor_image" accept="image/*"><br><br>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="submit-button">Add Doctor</button>
            </form>
        </div>
    </main>

    <!-- Footer Section -->
    <div class="footer">
        MediPlus Clinic &copy; 2024. All rights reserved.
    </div>

    <script>
        function validateForm() {
            const name = document.getElementById("name").value;
            const phone = document.querySelector("input[name='phone_number']").value;
            const specialization = document.getElementById("specialization").value;
            const description = document.getElementById("description").value;
            const imageInput = document.getElementById("doctor_image");
            const imageFile = imageInput.files[0];

            // Check if any field is empty
            if (!name || !phone || !specialization || !description || !imageFile) {
                alert("All fields are required.");
                return false; // Prevent form submission
            }

            // Check if image size is less than 5 MB
            if (imageFile.size > 5000000) {  // 5 MB size limit
                alert("Image must be less than 5 MB.");
                imageInput.value = "";  // Clear file input
                return false; // Prevent form submission
            }

            // Check if the file is a valid image type
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validImageTypes.includes(imageFile.type)) {
                alert("Only JPG, PNG, and GIF images are allowed.");
                imageInput.value = "";  // Clear file input
                return false; // Prevent form submission
            }

            return true; // Proceed with form submission
        }
    </script>

</body>

</html>
