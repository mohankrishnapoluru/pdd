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

// Fetch doctors with their specializations
$sql = "SELECT d.doctor_id, d.name AS doctor_name, d.phone_number, d.image_path, d.description, s.specialization_name 
        FROM doctors d
        JOIN specializations s ON d.specialization_id = s.specialization_id";
$result = $conn->query($sql);
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
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 36px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 50px auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .doctor-card {
            position: relative;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .doctor-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .doctor-image {
            width: 100%;
            height: 400px;
            background-color: #e0e0e0;
            background-size: cover;
            background-position: center;
        }

        .doctor-content {
            padding: 20px;
            flex-grow: 1;
        }

        .doctor-title {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .doctor-specialization {
            font-size: 16px;
            color: #27ae60;
            margin-bottom: 15px;
        }

        .doctor-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
            height: 30px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .doctor-phone {
            font-size: 14px;
            color: #1f6e6e;
            margin-bottom: 15px;
        }

        .book-appointment-btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        .book-appointment-btn:hover {
            background-color: #2980b9;
            transform: scale(1.05);
        }

        .no-doctors-message {
            text-align: center;
            font-size: 18px;
            color: #999;
            margin-top: 30px;
        }

        /* Footer Styling */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px 0;
            font-size: 14px;
        }

        footer a {
            color: #4f80ff;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr 1fr;
            }

            h1 {
                font-size: 28px;
            }

            .doctor-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <?php include("userheader.php"); ?>

    <main>
        <h1>Doctors Available</h1>

        <!-- Doctors Grid -->
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
                    <p class='doctor-phone'>📞 {$row['phone_number']}</p>
                    <a href='booking.php?doctor_id={$row['doctor_id']}' class='book-appointment-btn'>Book Appointment</a>
                </div>
            </div>";
                }
            } else {
                echo "<p class='no-doctors-message'>No doctors available at the moment.</p>";
            }
            ?>
        </div>
    </main>

    <!-- Footer -->
    <?php include("userfooter.php"); ?>
</body>

</html>
