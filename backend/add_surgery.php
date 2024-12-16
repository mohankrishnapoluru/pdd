<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $surgery_name = $_POST['surgery_name'];
    $description = $_POST['description'];

    // Handle file upload
    $image_path = null;
    if (isset($_FILES['surgery_image']) && $_FILES['surgery_image']['error'] == 0) {
        $target_dir = "../uploads/";

        // Check if directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Generate unique file name
        $image_name = uniqid() . "-" . basename($_FILES["surgery_image"]["name"]);
        $image_path = $target_dir . $image_name;

        // Validate file size
        if ($_FILES["surgery_image"]["size"] > 5000000) {  // 5MB size limit
            echo "File is too large.";
            $image_path = null;
        } else {
            // Validate file extension
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($_FILES["surgery_image"]["name"], PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions)) {
                echo "Invalid file type.";
                $image_path = null;
            } else {
                // Move uploaded file
                if (move_uploaded_file($_FILES["surgery_image"]["tmp_name"], $image_path)) {
                    echo "File uploaded successfully.";
                } else {
                    echo "Error uploading the file.";
                    $image_path = null;
                }
            }
        }
    } else {
        echo "Please select an image.";
    }

    // Insert surgery details into the database
    if ($surgery_name && $description && $image_path) {
        $stmt = $conn->prepare("INSERT INTO surgeries (surgery_name, description, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $surgery_name, $description, $image_path);

        if ($stmt->execute()) {
            header("Location: ../adminsurgery.php?success=1");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Missing data.";
    }
}

$conn->close();
?>
