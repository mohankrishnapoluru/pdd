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
    <title>Mediplus Clinic</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Body and HTML to cover the viewport */
        html,
        body {
            height: 100%;
            display: flex;
            flex-direction: column;
            background-color: #f4f7f6;
            color: #333;
        }

        /* Main content wrapper */
        .content {
            flex: 1; /* Ensures the content stretches */
        }

        /* Hero Section */
        .hero {
            text-align: center;
            padding: 40px 20px;
            background-color: #1c6e8c;
            color: #fff;
            margin-bottom: 30px;
        }

        .hero h2 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .hero h3 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 300;
        }

        /* Services Section */
        .services {
            text-align: center;
            padding: 60px 20px;
            background-color: #fff;
        }

        .services h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .services h3 {
            font-size: 24px;
            color: #1c6e8c;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .services-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            justify-items: center;
            align-items: center;
        }

        .service-item {
            background-color: #e1f2f1;
            padding: 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 350px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .service-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .service-item h4 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        /* Footer Section */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
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
            .hero h2 {
                font-size: 28px;
            }

            .hero h3 {
                font-size: 20px;
            }

            .services h2 {
                font-size: 28px;
            }

            .services-container {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero h2 {
                font-size: 24px;
            }

            .hero h3 {
                font-size: 18px;
            }

            .service-item {
                padding: 20px;
            }

            .services-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- Main Content -->
    <div class="content">
        <!-- Hero Section -->
        <section class="hero">
            <h2>Welcome to MediPlus Clinic</h2>
            <h3>Providing Excellence in Healthcare Services</h3>
        </section>

        <!-- Services Section -->
        <section class="services">
            <h2>Our Medical Services</h2>
            <h3>Comprehensive Care Tailored to Your Needs</h3>
            <div class="services-container">
                <div class="service-item">
                    <img src="images/emergencyambulance.jpg" alt="Emergency Service">
                    <a href="emergency.php"><h4>Emergency Services</h4></a>
                </div>
                <div class="service-item">
                    <img src="images/heart.jpeg" alt="Operation & Surgery">
                    <a href="surgery.php"><h4>Operation & Surgery</h4></a>
                </div>
                <div class="service-item">
                    <img src="images/checkup.jpg" alt="Checkup">
                    <a href="booking.php"><h4>Health Checkups</h4></a>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>
</body>

</html>
