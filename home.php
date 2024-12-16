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
            /* Reset and General Styles */
            {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            body {
                line-height: 1.6;
                background-color: #f9f9f9;
                color: #333;
            }

            /* Hero Section */
            .hero {
                background-image: url("images/image1.png");
                background-size: cover;
                background-position: center;
                padding: 60px 20px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                color: #fff;
                min-height: 400px;
            }   

            .hero-content {
                background: rgba(0, 0, 0, 0.5);
                padding: 20px;
                border-radius: 8px;
            }

            .hero h2 {
                font-size: 36px;
                margin-bottom: 15px;
            }

            .hero h3 {
                font-size: 28px;
                margin-bottom: 25px;
            }

            .hero .emergency-btn {
                background-color: #e63946;
                color: #fff;
                padding: 15px 30px;
                border: none;
                border-radius: 5px;
                font-size: 18px;
                font-weight: bold;
                text-decoration: none;
                transition: background-color 0.3s ease, transform 0.2s ease;
            }

            .hero .emergency-btn:hover {
                background-color: #d62828;
                transform: scale(1.05);
            }

            /* About Section */
            .about {
                padding: 50px 20px;
                background-color: #ffffff;
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: 30px;
            }

            .about img {
                flex: 1;
                max-width: 400px;
                height: auto;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .about-content {
                flex: 2;
                text-align: left;
            }

            .about h2 {
                font-size: 32px;
                margin-bottom: 15px;
                color: #2d2d2d;
            }

            .about h3 {
                font-size: 24px;
                margin-bottom: 20px;
                color: #4f80ff;
            }

            .about p {
                font-size: 16px;
                line-height: 1.8;
                color: #555;
            }

            /* Footer Section */
            footer {
                background-color: #333;
                color: #fff;
                padding: 20px;
                text-align: center;
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
                .hero {
                    padding: 40px 20px;
                    text-align: center;
                }

                .hero-content {
                    margin: 0 auto;
                }

                .hero h2 {
                    font-size: 28px;
                }

                .hero h3 {
                    font-size: 22px;
                }

                .about {
                    flex-direction: column;
                    text-align: center;
                }

                .about img {
                    max-width: 100%;
                }

                .about-content {
                    text-align: center;
                }
            }
        </style>
    </head>
    <body>
        <!-- Header Section -->
        <?php include("userheader.php"); ?>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h2>WELCOME TO MEDIPLUS CLINIC</h2>
                <h3>Best Healthcare Hospital In Your City</h3>
                <a href="emergency.php" class="emergency-btn">Emergency</a>
            </div>
        </section>

        <!-- About Section -->
        <section class="about">
            <img src="images/home-2.webp" alt="About Us Image">
            <div class="about-content">
                <h2>ABOUT US</h2>
                <h3>Best Medical Care</h3>
                <p>Welcome to Mediplus Clinic, where compassionate care meets medical excellence. Established with a commitment to delivering high-quality healthcare, our hospital brings together a team of experienced specialists, skilled medical staff, and state-of-the-art facilities to provide comprehensive care for patients of all ages.</p>
            </div>
        </section>

        <!-- Footer Section -->
        <?php include("userfooter.php"); ?>
    </body>
    </html>
