<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Show Directions</title>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
        <style>
            /* Basic styling */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            .header-main {
                background-color: #f2b8b8;
                padding: 10px;
                text-align: center;
            }

            .header-main h1 {
                color: #1f6e6e;
            }

            h1 {
                text-align: center;
                color: #1f6e6e;
                margin-top: 20px;
            }

            /* Map Styling */
            #map {
                width: 100%;
                height: 500px;
                margin: 20px 0;
            }

            /* Responsive Design */
            @media (max-width: 768px) {
                #map {
                    height: 400px;
                }
            }

            @media (max-width: 600px) {
                #map {
                    height: 300px;
                }

                .header-main h1 {
                    font-size: 18px;
                }

                h1 {
                    font-size: 20px;
                }
            }
        </style>
    </head>

    <body>
        <!-- Header Section -->
        <?php include("adminheader.php"); ?>

        <h1>Get Directions</h1>

        <!-- Map Section -->
        <div id="map"></div>

        <script>
            // Parse latitude and longitude from the URL
            const urlParams = new URLSearchParams(window.location.search);
            const targetLat = parseFloat(urlParams.get('lat'));
            const targetLng = parseFloat(urlParams.get('lng'));

            if (!targetLat || !targetLng) {
                alert('Invalid location coordinates!');
                window.history.back();
            }

            // Initialize the map
            const map = L.map('map').setView([targetLat, targetLng], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Get user's current location
            navigator.geolocation.getCurrentPosition((position) => {
                const userLat = position.coords.latitude;
                const userLng = position.coords.longitude;

                // Use Leaflet Routing Machine to display directions
                L.Routing.control({
                    waypoints: [
                        L.latLng(userLat, userLng), // User's location
                        L.latLng(targetLat, targetLng) // Target location
                    ],
                    routeWhileDragging: true,
                }).addTo(map);
            }, () => {
                alert('Unable to retrieve your location.');
            });
        </script>
    </body>     

    </html>
            