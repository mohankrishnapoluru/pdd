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
// Handle delete request for doctors
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_appointments_sql = "DELETE FROM appointments WHERE doctor_id = $delete_id";
    $conn->query($delete_appointments_sql);

    $delete_sql = "DELETE FROM doctors WHERE doctor_id = $delete_id";
    $conn->query($delete_sql);

    header("Location: adoctoravailable.php"); // Refresh the page after deletion
    exit;
}

// Handle add specialization request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['specialization_name'])) {
    $specialization_name = $conn->real_escape_string($_POST['specialization_name']);
    $add_specialization_sql = "INSERT INTO specializations (specialization_name) VALUES ('$specialization_name')";
    $conn->query($add_specialization_sql);

    header("Location: adoctoravailable.php"); // Refresh the page after adding
    exit;
}

// Handle edit specialization request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_specialization_id'])) {
    $specialization_id = $_POST['edit_specialization_id'];
    $specialization_name = $conn->real_escape_string($_POST['edit_specialization_name']);

    $edit_specialization_sql = "UPDATE specializations SET specialization_name = '$specialization_name' WHERE specialization_id = $specialization_id";
    $conn->query($edit_specialization_sql);

    header("Location: adoctoravailable.php"); // Refresh the page after editing
    exit;
}

// Fetch doctors with their specializations
$sql = "SELECT d.doctor_id, d.name AS doctor_name, d.phone_number, d.image_path, d.description, s.specialization_name 
        FROM doctors d
        JOIN specializations s ON d.specialization_id = s.specialization_id";
$result = $conn->query($sql);

// Fetch specializations
$specializations_sql = "SELECT specialization_id, specialization_name FROM specializations";
$specializations_result = $conn->query($specializations_sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors Available - MediPlus Clinic</title>
    <style>
        /* General Body Style */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .add-doctor-button {
            position:absolute;
            top: 70px;
            right: 20px;
            background: #00b894; /* Greenish Color */
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .add-doctor-button:hover {
            background: #009c80;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .doctor-card {
            position: relative;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .doctor-image {
            width: 100%;
            height: 390px;
            background-color: #e0e0e0;
            background-size: cover;
            background-position: center;
        }

        .doctor-content {
            padding: 20px;
        }

        .doctor-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .doctor-specialization {
            font-size: 16px;
            color: #e67e22; /* Orange Color */
            margin-bottom: 10px;
        }

        .doctor-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .doctor-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .doctor-phone {
            font-size: 14px;
            color: #1f6e6e;
        }

        .doctor-button {
            background: #ff4d4f;
            color: #fff;
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .doctor-button:hover {
            background: #e60000;
        }

        /* Specializations Section */
        section {
            margin: 50px auto;
            max-width: 800px;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        table th,
        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        form {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        form input {
            flex: 1;
            padding: 10px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-right: 10px;
        }

        form button {
            background: #00b894;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        form button:hover {
            background: #009c80;
        }

        /* Edit Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php include("adminheader.php"); ?>
    <a href="adoctadd.php" class="add-doctor-button">+ Add Doctor</a>

    <main>
        <!-- Specializations Section -->
        <section>
            <h2>Specializations</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Specialization Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($specializations_result->num_rows > 0) {
                        while ($row = $specializations_result->fetch_assoc()) {
                            echo "
                    <tr>
                        <td>{$row['specialization_id']}</td>
                        <td>{$row['specialization_name']}</td>
                        <td>
                            <button class='edit-button' data-id='{$row['specialization_id']}' data-name='{$row['specialization_name']}'>Edit</button>
                        </td>
                    </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No specializations available.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <form method="POST">
                <input type="text" name="specialization_name" placeholder="Add new specialization" required>
                <button type="submit">Add</button>
            </form>
        </section>

        <!-- Doctor Cards Section -->
        <div class="container">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
            <div class='doctor-card'>
                <div class='doctor-image' style='background-image: url(backend/{$row['image_path']});'></div>
                <div class='doctor-content'>
                    <h3 class='doctor-title'>Dr. {$row['doctor_name']}</h3>
                    <p class='doctor-specialization'>{$row['specialization_name']}</p>
                    <p class='doctor-description'>{$row['description']}</p>
                    <div class='doctor-footer'>
                        <p class='doctor-phone'>📞 {$row['phone_number']}</p>
                        <p class='doctor-id'>ID: {$row['doctor_id']}</p> <!-- Displaying Doctor ID -->
                        <a href='adoctoravailable.php?delete_id={$row['doctor_id']}' class='doctor-button' onclick='return confirm(\"Are you sure you want to delete this doctor?\");'>Delete</a>
                    </div>
                </div>
            </div>";
                }
            } else {
                echo "<p>No doctors available.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Specialization</h2>
            <form method="POST">
                <input type="hidden" name="edit_specialization_id" id="editSpecializationId">
                <input type="text" name="edit_specialization_name" id="editSpecializationName" required>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>

    <script>
        // Modal functionality
        const editButtons = document.querySelectorAll('.edit-button');
        const modal = document.getElementById('editModal');
        const closeModal = document.querySelector('.close');
        const editSpecializationId = document.getElementById('editSpecializationId');
        const editSpecializationName = document.getElementById('editSpecializationName');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const specializationId = button.getAttribute('data-id');
                const specializationName = button.getAttribute('data-name');
                editSpecializationId.value = specializationId;
                editSpecializationName.value = specializationName;
                modal.style.display = 'block';
            });
        });

        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
    </script>
</body>

</html>
