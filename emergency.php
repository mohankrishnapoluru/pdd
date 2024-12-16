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
    <!-- Leaflet.js CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet.js JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Main Content Section */
        .main-content {
            padding: 50px 20px;
            text-align: center;
            background-color: #f7f7f7;
        }

        .main-content img {
            width: 90%;
            max-width: 650px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .main-content h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .main-content p {
            font-size: 18px;
            line-height: 1.7;
            max-width: 750px;
            margin: 0 auto 40px;
            color: #555;
        }

        /* Callback Form */
        .callback-form {
            background-color: #e0f7fa;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            margin: 0 auto 40px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        }

        .callback-form h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .callback-form input {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .callback-form button {
            width: 100%;
            padding: 12px;
            background-color: #4f80ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .callback-form button:hover {
            background-color: #365ec3;
        }

        /* Map Section */
        #map {
            height: 400px;
            width: 85%;
            margin: 20px auto;
            border-radius: 12px;
            border: 2px solid #ccc;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Fetch Location Button */
        .location-button {
            position: absolute;
            top: 10px;
            right: 20px;
            z-index: 1000;
            background-color: #4f80ff;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 18px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .location-button:hover {
            background-color: #365ec3;
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- Main Content Section -->
    <section class="main-content">
        <img src="images/emergencyambulance.jpg" alt="Emergency Department">
        <h2>Understanding The Role Of Emergency Department</h2>
        <p>The Emergency Department (ED) is a critical area in the hospital where patients receive immediate treatment for urgent and life-threatening conditions. It operates 24/7, providing fast, responsive care for anyone in need of urgent medical attention.</p>

        <!-- Callback Form -->
        <div class="callback-form">
            <h3>Request a Callback</h3>
            <form action="backend/submit_callback.php" method="POST" id="callbackForm">
                <input type="text" name="name" placeholder="Enter Your Name*" required>
                <input type="text" name="mobile_number" placeholder="Enter Your Mobile Number*" required>
                <!-- Hidden input for location -->
                <input type="hidden" name="location" id="location">
                <button type="submit">Submit</button>
            </form>
        </div>

        <!-- Map Section -->
        <div id="map">
            <button class="location-button" id="fetchLocation">📍 Fetch Current Location</button>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>

    <script>
        let map, marker;

        function initializeMap() {
            // Default coordinates (centered on India)
            let lat = 20.5937;
            let lng = 78.9629;

            // Create a map instance
            map = L.map('map').setView([lat, lng], 5); // Default zoom is 5

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Handle map clicks to update location
            map.on('click', function (e) {
                const { lat, lng } = e.latlng;
                updateMarker(lat, lng);
            });

            // Initialize current location
            fetchCurrentLocation();
        }

        function fetchCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        updateMarker(lat, lng);
                        map.setView([lat, lng], 13); // Zoom to 13
                    },
                    function () {
                        alert("Geolocation is not supported or permission was denied.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function updateMarker(lat, lng) {
            // Update hidden input
            document.getElementById('location').value = `${lat},${lng}`;

            // Add or move the marker
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng]).addTo(map).bindPopup("Selected Location").openPopup();
            }
        }

        // Initialize the map on page load
        window.onload = initializeMap;

        // Fetch location button click event
        document.getElementById('fetchLocation').onclick = fetchCurrentLocation;
    </script>
</body>

</html>
