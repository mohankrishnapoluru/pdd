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

// Get the doctor_id from the URL
$selected_doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : null;

// Fetch specializations
$specializations_sql = "SELECT * FROM specializations";
$specializations_result = $conn->query($specializations_sql);

// Fetch doctors
$doctor_sql = "SELECT * FROM doctors";
$doctor_result = $conn->query($doctor_sql);

// Get the selected doctor's details
$selected_doctor = null;
if ($selected_doctor_id) {
    $doctor_details_sql = "SELECT * FROM doctors WHERE doctor_id = $selected_doctor_id";
    $doctor_details_result = $conn->query($doctor_details_sql);
    $selected_doctor = $doctor_details_result->fetch_assoc();
}

// Get today's date
$today = date('Y-m-d');
$maxDate = date('Y-m-d', strtotime('+5 days'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mediplus Clinic - Book Appointment</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        /* Body Background */
        body {
            background: url('/images/image1.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
        }

        /* Appointment Section */
        .appointment {
            padding: 60px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
        }

        .appointment-form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        .appointment-form h3 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #4f80ff;
        }

        .appointment-form label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 600;
        }

        .appointment-form input,
        .appointment-form select,
        .appointment-form textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .appointment-form select {
            background-color: #fafafa;
        }

        .appointment-form textarea {
            resize: vertical;
        }

        .appointment-form button {
            width: 100%;
            padding: 15px;
            background-color: #4f80ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .appointment-form button:hover {
            background-color: #365ec3;
        }

        /* Footer Section */
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
        }

        footer p {
            font-size: 14px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const specializationSelect = document.getElementById('specializations');
            const doctorSelect = document.getElementById('doctor');

            // Automatically load doctors when the specialization changes
            specializationSelect.addEventListener('change', function () {
                const specializationId = specializationSelect.value;
                doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

                if (specializationId) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', `backend/get_doctors.php?specialization_id=${specializationId}`, true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            const doctors = JSON.parse(xhr.responseText);
                            if (doctors.length > 0) {
                                doctors.forEach(function (doctor) {
                                    const option = document.createElement('option');
                                    option.value = doctor.doctor_id;
                                    option.textContent = doctor.name;
                                    doctorSelect.appendChild(option);
                                });

                                // Automatically select the doctor if pre-selected
                                <?php if ($selected_doctor_id): ?>
                                doctorSelect.value = <?= $selected_doctor_id ?>;
                                <?php endif; ?>
                            } else {
                                doctorSelect.innerHTML = '<option value="">No doctors available</option>';
                            }
                        }
                    };
                    xhr.send();
                }
            });

            // Automatically trigger change if a doctor is pre-selected
            <?php if ($selected_doctor): ?>
            specializationSelect.value = <?= $selected_doctor['specialization_id'] ?>;
            specializationSelect.dispatchEvent(new Event('change'));
            <?php endif; ?>
        });
    </script>
</head>

<body>
    <!-- Header -->
    <?php include("userheader.php"); ?>

    <section class="appointment">
        <div class="appointment-form">
            <h3>Book an Appointment</h3>
            <form action="backend/submit_booking.php" method="post">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" placeholder="Enter your name" required>

                <label for="date">Date *</label>
                <input type="date" id="date" name="date" min="<?= $today ?>" max="<?= $maxDate ?>" required>

                <label for="time">Time Slot *</label>
                <select id="time" name="time" required>
                    <option value="">Select Time Slot</option>
                    <option value="09:00">09:00 AM</option>
                    <option value="10:30">10:30 AM</option>
                    <option value="12:00">12:00 PM</option>
                    <option value="13:30">01:30 PM</option>
                    <option value="15:00">03:00 PM</option>
                    <option value="16:30">04:30 PM</option>
                    <option value="18:00">06:00 PM</option>
                    <option value="19:30">07:30 PM</option>
                </select>

                <label for="phone">Mobile Number *</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your mobile number" required>

                <label for="address">Address *</label>
                <textarea id="address" name="address" placeholder="Enter your address" rows="3" required></textarea>

                <label for="appointment-type">Appointment Type *</label>
                <select id="appointment-type" name="appointment_type" required>
                    <option value="">Select Appointment Type</option>
                    <option value="hospital-visit">Hospital Consultation</option>
                    <option value="house-visit">Video Consultation</option>
                </select>

                <label for="specializations">Specialization *</label>
                <select id="specializations" name="specializations" required>
                    <option value="">Choose Specialization</option>
                    <?php while ($specialization = $specializations_result->fetch_assoc()): ?>
                        <option value="<?= $specialization['specialization_id'] ?>">
                            <?= htmlspecialchars($specialization['specialization_name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="doctor">Doctor *</label>
                <select id="doctor" name="doctor" required>
                    <option value="">Select Doctor</option>
                    <?php while ($doctor = $doctor_result->fetch_assoc()): ?>
                        <option value="<?= $doctor['doctor_id'] ?>" 
                            <?= $selected_doctor_id == $doctor['doctor_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($doctor['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button type="submit">Book Appointment</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <?php include("userfooter.php"); ?>
</body>

</html>
