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

$user_id = $_SESSION["id"];
$sql = "SELECT * FROM signup WHERE id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $password = $row['password'];
    $mobile = $row['mobile'];
    $name = $row['name'];
} else {
    die("User not found.");
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Mediplus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body and Background */
        body {
            background-color: #f9f9f9;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Header Section */
        header {
            background-color: #3498db;
            padding: 20px 0;
            text-align: center;
            color: white;
            font-size: 24px;
        }

        /* Profile Section */
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 70vh;
            padding: 50px 20px;
        }

        .profile-box {
            width: 100%;
            max-width: 450px;
            padding: 25px;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .profile-box h2 {
            text-align: center;
            font-size: 28px;
            color: #333;
            margin-bottom: 30px;
        }

        .profile-field {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            font-size: 16px;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        .profile-field:last-child {
            border-bottom: none;
        }

        .profile-field span {
            font-weight: bold;
            color: #3498db;
        }

        .profile-box .save-button {
            margin-top: 30px;
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .profile-box .save-button:hover {
            background-color: #2980b9;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fefefe;
            padding: 25px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            border-radius: 8px;
            position: relative;
        }

        .modal-content label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        .modal-content input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .modal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 28px;
            color: #aaa;
            cursor: pointer;
        }

        .submit-button {
            padding: 12px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .submit-button:hover {
            background-color: #218838;
        }

        /* Footer Section */
        footer {
            background-color: #3a3b3c;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        footer a {
            color: #ddd;
            text-decoration: none;
        }

        footer a:hover {
            color: #3498db;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- User Profile Section -->
    <section class="profile-container">
        <div class="profile-box">
            <h2>Profile</h2>
            <div class="profile-field">
                <span>Name</span>
                <p><?php echo $name; ?></p>
            </div>
            <div class="profile-field">
                <span>Username</span>
                <p><?php echo $username; ?></p>
            </div>
            <div class="profile-field">
                <span>Mobile Number</span>
                <p><?php echo $mobile; ?></p>
            </div>
            <div class="profile-field">
                <span>User ID</span>
                <p><?php echo $user_id; ?></p>
            </div>
            <button class="save-button" id="edit-button">Edit Profile</button>
        </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <h3>Edit Profile</h3>
            <form id="editForm">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <label for="edit-name">Name</label>
                <input type="text" id="edit-name" name="name" value="<?php echo $name; ?>" required>
                <label for="edit-mobile">Mobile</label>
                <input type="text" id="edit-mobile" name="mobile" value="<?php echo $mobile; ?>" required>
                <button type="submit" class="submit-button">Save</button>
            </form>
        </div>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Mediplus Clinic | All Rights Reserved</p>
        <p>Follow Us on:</p>
        <a href="https://twitter.com">🐦 Twitter</a> | 
        <a href="https://www.instagram.com">📸 Instagram</a> | 
        <a href="https://www.linkedin.com">🔗 LinkedIn</a>
    </footer>

    <script>
        const editModal = document.getElementById("editModal");
        const editButton = document.getElementById("edit-button");
        const closeModal = document.getElementById("closeModal");

        editButton.onclick = () => editModal.style.display = "flex";
        closeModal.onclick = () => editModal.style.display = "none";
        window.onclick = (event) => {
            if (event.target === editModal) editModal.style.display = "none";
        };

        const editForm = document.getElementById("editForm");
        editForm.onsubmit = function (event) {
            event.preventDefault();
            const formData = new FormData(editForm);
            fetch("backend/update_user.php", { method: "POST", body: formData })
                .then(response => response.text())
                .then(data => {
                    if (data === "success") {
                        alert("Profile updated successfully!");
                        location.reload();
                    } else {
                        alert("Failed to update profile. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
        };
    </script>
</body>

</html>
