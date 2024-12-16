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

// Fetch surgery details from the database
$sql = "SELECT * FROM surgeries";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surgery Details - MediPlus Clinic</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            height: 100%;
            background-color: #f7f7f7;
        }

        /* Page Header */
        header {
            background-color: #1c6e8c;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-size: 36px;
        }

        /* Surgeries Section */
        .surgeries-section {
            padding: 50px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        /* Individual Surgery Card */
        .surgery-card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 350px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .surgery-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .surgery-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 5px solid #1c6e8c;
        }

        .surgery-card .content {
            padding: 20px;
            color: #333;
        }

        .surgery-card h4 {
            font-size: 20px;
            color: #1c6e8c;
            margin-bottom: 10px;
        }

        .surgery-card p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            text-align: justify;
        }

        /* Footer Section */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
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
            header h1 {
                font-size: 28px;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <?php include("userheader.php"); ?>

    <!-- Surgery Details Section -->
    <section class="surgeries-section">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="surgery-card">
                <img src="uploads/<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['surgery_name']) ?>">
                <div class="content">
                    <h4><?= htmlspecialchars($row['surgery_name']) ?></h4>
                    <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- Footer Section -->
    <?php include("userfooter.php"); ?>
    
</body>

</html>

<?php
$conn->close();
?>
