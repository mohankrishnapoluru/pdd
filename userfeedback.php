<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - Feedback Form</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-image: url('images/image1.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header Styles */
        header {
            background-color: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        header h1 {
            font-size: 24px;
            margin: 0;
        }

        /* Feedback Form */
        .feedback-form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 650px;
            margin: 40px auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .feedback-form h3,
        .feedback-form h4 {
            text-align: center;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .feedback-form label {
            display: block;
            margin-top: 15px;
            font-weight: 600;
            color: #34495e;
        }

        .feedback-form input,
        .feedback-form select,
        .feedback-form textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .feedback-form textarea {
            resize: vertical;
            height: 120px;
        }

        .feedback-form select {
            background-color: #fff;
        }

        .feedback-form button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: #4f80ff;
            color: #fff;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .feedback-form button:hover {
            background-color: #365ec3;
        }

        /* Footer Styles */
        footer {
            background-color: #34495e;
            color: white;
            padding: 25px 20px;
            text-align: center;
        }

        footer a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- Feedback Form Section -->
    <section class="feedback-form">
        <h4>We Value Your Feedback</h4>
        <h3>Feedback Form</h3>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hospital";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch doctors
        $doctorQuery = "SELECT doctor_id, name FROM doctors";
        $result = $conn->query($doctorQuery);
        ?>

        <form action="backend/submit_feedback.php" method="post">
            <label for="name">First Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" required>

            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your Phone Number" required>

            <label for="doctor">Choose a Doctor</label>
            <select id="doctor" name="doctor" required>
                <option value="">Select Doctor...</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['doctor_id'] . "'>" . htmlspecialchars($row['name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No doctors available</option>";
                }
                ?>
            </select>

            <label for="message">Your Feedback</label>
            <textarea id="message" name="message" placeholder="Type your feedback..." required></textarea>

            <button type="submit">Submit Feedback</button>
        </form>

        <?php $conn->close(); ?>
    </section>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>
</body>

</html>