<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - Admin</title>
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

        @media (max-width: 768px) {
            .navbar-nav {
                text-align: center;
            }

            .dropdown-menu {
                position: static;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark py-3 py-lg-0">
        <a href="adminhome.php" class="navbar-brand">
            <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-clinic-medical me-2"></i>Mediplus Admin</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav ms-auto py-0">
                <li class="nav-item">
                    <a href="adminhome.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Services</a>
                    <ul class="dropdown-menu">
                        <li><a href="adoctoravailable.php" class="dropdown-item">Doctors Availability</a></li>
                        <li><a href="adoctadd.php" class="dropdown-item">Add Doctor</a></li>
                        <li><a href="adminsurgery.php" class="dropdown-item">Surgery</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Appointments</a>
                    <ul class="dropdown-menu">
                        <li><a href="admin_view_appointments.php" class="dropdown-item">View Appointments</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="acallback.php" class="nav-link">Emergency Call Back</a>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Users</a>
                    <ul class="dropdown-menu">
                        <li><a href="manageusers.php" class="dropdown-item">View Users</a></li>
                        <li><a href="aview_feedback.php" class="dropdown-item">User Feedback</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="index.html" class="nav-link">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
