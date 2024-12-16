<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch specialization options
$specializations = [];
$sql = "SELECT specialization_id, specialization_name FROM specializations";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $specializations[] = $row;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if required fields are filled
    if (empty($_POST['name']) || empty($_POST['phone_number']) || empty($_POST['specialization']) || empty($_POST['description'])) {
        echo "All fields are required.";
    } else {
        // Get form data
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $specialization_id = $_POST['specialization'];
        $description = $_POST['description'];

        // Handle file upload
        $image_path = null;
        if (isset($_FILES['doctor_image']) && $_FILES['doctor_image']['error'] == 0) {
            $target_dir = "uploads/";

            // Check if directory exists
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            // Generate unique file name
            $image_name = uniqid() . "-" . basename($_FILES["doctor_image"]["name"]);
            $image_path = $target_dir . $image_name;

            // Validate file size
            if ($_FILES["doctor_image"]["size"] > 5000000) {
                echo "File is too large.";
                $image_path = null;
            } else {
                // Validate file extension
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $file_extension = strtolower(pathinfo($_FILES["doctor_image"]["name"], PATHINFO_EXTENSION));
                if (!in_array($file_extension, $allowed_extensions)) {
                    echo "Invalid file type.";
                    $image_path = null;
                } else {
                    // Move uploaded file
                    if (move_uploaded_file($_FILES["doctor_image"]["tmp_name"], $image_path)) {
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

        // Insert doctor details, including image path
        if ($specialization_id && $image_path) {
            $stmt = $conn->prepare("INSERT INTO doctors (name, phone_number, specialization_id, description, image_path) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiss", $name, $phone_number, $specialization_id, $description, $image_path);

            if ($stmt->execute()) {
                header("Location: ../adoctoravailable.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error: Missing data.";
        }
    }
}
$conn->close();
?>
     