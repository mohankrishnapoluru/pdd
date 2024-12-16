<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - User</title>
    <style>
        /* Reset and General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        /* Header Styles */
        .header-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 20px;
            background-color: #2d2d2d;
            color: #ffffff;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-main h1 {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        nav {
            display: flex;
            align-items: center;
        }

        nav a {
            color: #ffffff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            position: relative;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #3498db;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown a::after {
            content: '▼';
            font-size: 10px;
            margin-left: 5px;
            color: #ffffff;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #ffffff;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            overflow: hidden;
            top: 100%;
            left: 0;
            z-index: 100;
        }

        .dropdown-content a {
            color: #333333;
            padding: 10px 15px;
            text-decoration: none;
            font-size: 14px;
            display: block;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #f0f0f0;
            color: #3498db;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Mobile Menu */
        .hamburger {
            display: none;
            font-size: 24px;
            cursor: pointer;
            color: #ffffff;
        }

        .mobile-menu {
            display: none;
            flex-direction: column;
            background-color: #2d2d2d;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .mobile-menu.active {
            display: flex;
        }

        .mobile-menu a {
            padding: 15px 20px;
            text-decoration: none;
            color: #ffffff;
            border-bottom: 1px solid #444;
        }

        .mobile-menu a:hover {
            background-color: #3498db;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .hamburger {
                display: block;
            }

            .dropdown-content {
                position: relative;
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <header class="header-main">
        <!-- Logo Section -->
        <div class="logo-section">
            <h1>MEDIPLUS CLINIC</h1>
        </div>

        <!-- Hamburger Icon -->
        <div class="hamburger" onclick="toggleMenu()">☰</div>

        <!-- Desktop Navigation -->
        <nav>
            <a href="home.php">Home</a>
            <div class="dropdown">
                <a href="about.php">About</a>
                <div class="dropdown-content">
                    <a href="docavailable.php">Qualified Doctors</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="services.php">Services</a>
                <div class="dropdown-content">
                    <a href="emergency.php">Emergency Services</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="booking.php">Appointment</a>
                <div class="dropdown-content">
                    <a href="booking.php">Take Appointment</a>
                    <a href="userbookinghistorypage.php">Appointment History</a>
                </div>
            </div>
            <a href="userfeedback.php">Feedback</a>
            <div class="dropdown">
                <a href="userprofile.php">Profile</a>
                <div class="dropdown-content">
                    <a href="userprofile.php">User Profile</a>
                    <a href="backend/logout.php">Logout</a>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="home.php">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="booking.php">Appointment</a>
            <a href="userbookinghistorypage.php">Appointment History</a>
            <a href="userfeedback.php">Feedback</a>
            <a href="userprofile.php">Profile</a>
            <a href="backend/logout.php">Logout</a>
        </div>
    </header>

    <script>
        function toggleMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }
    </script>
</body>

</html>
