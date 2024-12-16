<?php
include('config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Delete the callback request from the database
    $sql = "DELETE FROM callbackrequests WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        
        
        echo "
        <script>
            alert('Callback deleted successfully!');
            window.location.href = '../acallback.php';
        </script>";
    } else {
        echo "Error deleting request: " . $conn->error;
    }
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

