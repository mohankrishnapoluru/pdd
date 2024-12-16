<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #2d2d2d;
        }

        .navbar-brand h1 {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        .nav-item a {
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            transition: color 0.3s ease;
        }

        .nav-item a:hover {
            color: #3498db;
        }

        .dropdown-menu {
            background-color: #2d2d2d;
            border: none;
        }

        .dropdown-menu a {
            font-size: 14px;
            color: #ffffff;
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .dropdown-menu a:hover {
            background-color: #3498db;
            color: #ffffff;
        }

        .navbar-toggler {
            border-color: #ffffff;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba%288, 8, 8, 1%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0">
        <a href="index.html" class="navbar-brand">
            <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>MediplusClinic</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto py-0">
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">About</a>
                    <ul class="dropdown-menu">
                        <li><a href="docavailable.php" class="dropdown-item">Qualified Doctors</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                        <li><a href="emergency.php" class="dropdown-item">Emergency Services</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Appointment</a>
                    <ul class="dropdown-menu">
                        <li><a href="booking.php" class="dropdown-item">Take Appointment</a></li>
                        <li><a href="userbookinghistorypage.php" class="dropdown-item">Appointment History</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="userfeedback.php" class="nav-link">Feedback</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Profile</a>
                    <ul class="dropdown-menu">
                        <li><a href="userprofile.php" class="dropdown-item">User Profile</a></li>
                        <li><a href="backend/logout.php" class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
