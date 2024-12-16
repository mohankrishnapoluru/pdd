<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - Admin</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f0f2f5;
        }

        /* Header Section */
        .header-main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #0066cc;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo-section h1 {
            color: #fff;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .logo-section span {
            color: #ffcc00;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        nav a {
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        nav a:hover {
            background-color: #ffcc00;
            color: #003366;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 110%;
            left: 0;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            z-index: 10;
        }

        .dropdown-content a {
            color: #333;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: #f5f5f5;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Mobile Responsiveness */
        .hamburger-menu {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 3px;
        }

        .hamburger-menu div {
            width: 25px;
            height: 3px;
            background-color: #fff;
            border-radius: 2px;
        }

        .mobile-nav {
            display: none;
            flex-direction: column;
            background-color: #0066cc;
            padding: 10px 20px;
            position: absolute;
            top: 60px;
            right: 0;
            width: 100%;
            z-index: 10;
        }

        .mobile-nav a {
            padding: 10px 0;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            nav {
                display: none;
            }

            .hamburger-menu {
                display: flex;
            }

            .mobile-nav {
                display: none;
            }

            .mobile-nav.active {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <header class="header-main">
        <div class="logo-section">
            <h1><span>MEDIPLUS</span> CLINIC</h1>
        </div>
        <nav>
            <a href="adminhome.php">Home</a>
            <div class="dropdown">
                <a href="#">Services</a>
                <div class="dropdown-content">
                    <a href="adoctoravailable.php">Doctors Availability</a>
                    <a href="adoctadd.php">Add Doctor</a>
                    <a href="adminsurgery.php">Surgery</a>
                </div>
            </div>
            <div class="dropdown">
                <a href="#">Appointments</a>
                <div class="dropdown-content">
                    <a href="admin_view_appointments.php">View Appointments</a>
                </div>
            </div>
            <a href="acallback.php">Emergency Call Back</a>
            <div class="dropdown">
                <a href="#">Users</a>
                <div class="dropdown-content">
                    <a href="manageusers.php">View Users</a>
                    <a href="aview_feedback.php">User Feedback</a>
                </div>
            </div>
            <a href="index.html">Logout</a>
        </nav>

        <div class="hamburger-menu" id="hamburger-menu">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="mobile-nav" id="mobile-nav">
            <a href="adminhome.php">Home</a>
            <a href="adoctoravailable.php">Doctors Availability</a>
            <a href="adoctadd.php">Add Doctor</a>
            <a href="adminsurgery.php">Surgery</a>
            <a href="admin_view_appointments.php">Appointments</a>
            <a href="acallback.php">Emergency Call Back</a>
            <a href="manageusers.php">View Users</a>
            <a href="aview_feedback.php">User Feedback</a>
            <a href="index.html">Logout</a>
        </div>
    </header>

    <script>
        const hamburgerMenu = document.getElementById('hamburger-menu');
        const mobileNav = document.getElementById('mobile-nav');

        hamburgerMenu.addEventListener('click', () => {
            mobileNav.classList.toggle('active');
        });
    </script>
</body>

</html>
