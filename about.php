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
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f7f6;
            color: #333;
            line-height: 1.6;
        }

        /* Header Section */
        header {
            background-color: #2E3B47;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        /* About Section */
        .about {
            background-color: #E5E1DA;
            padding: 60px 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            align-items: center;
        }

        .about img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .about-content {
            flex: 1;
            text-align: left;
            max-width: 600px;
        }

        .about h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .about h3 {
            font-size: 24px;
            color: #2C3E50;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .about p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }

        /* Services Section */
        .service {
            background-color: #8EA3A6;
            padding: 60px 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
            align-items: center;
        }

        .service img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .service-content {
            flex: 1;
            text-align: left;
            max-width: 600px;
        }

        .service h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .service h3 {
            font-size: 20px; 
            color: #2C3E50;
            /* margin-bottom: 20px; */
            font-weight: bold;
        }

        .service p {
            font-size: 16px;
            line-height: 1.8;
            color: #555;
        }

        .service a {
            text-decoration: none;
            color: white;
            background-color: #2980B9;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            display: inline-block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .service a:hover {
            background-color: #1F6F8B;
        }

        /* Footer Section */
        footer {
            background-color: #2E3B47;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        footer a {
            color: #2980B9;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .about, .service {
                flex-direction: column;
                text-align: center;
            }

            .about img, .service img {
                max-width: 100%;
            }

            .about h2, .service h2 {
                font-size: 28px;
            }

            .about h3, .service h3 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- About Section -->
    <section class="about">
        <img src="images/home-2.webp" alt="About Us Image">
        <div class="about-content">
            <h2>ABOUT US</h2>
            <h3>Best Medical Care</h3>
            <p>Welcome to Mediplus Clinic, where compassionate care meets medical excellence. Established with a commitment to delivering high-quality healthcare, our hospital brings together a team of experienced specialists, skilled medical staff, and state-of-the-art facilities to provide comprehensive care for patients of all ages.</p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="service">
        <img src="images/mendoctor.jpeg" alt="Qualified Doctors">
        <div class="service-content">
            <a href="docavailable.php"><h3>Qualified Doctors</h3></a>
            <p>Our team of experienced doctors at Mediplus Clinic is dedicated to providing compassionate care and expert medical guidance. With diverse specializations, they ensure comprehensive and personalized treatment for every patient. Your health and well-being are our top priority.</p>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>
</body>
</html>
