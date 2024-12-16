<?php
include('config.php');

if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    // Validate status to be either 'completed' or 'pending'
    if ($status == 'completed' || $status == 'pending') {
        // Update the task status in the database
        $sql = "UPDATE callbackrequests SET status = '$status' WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
           // echo "Task status updated to $status.";
            header("Location: ../adminhome.php?message=Task+Updated+Successfully");
        } else {
            echo "Error updating task: " . $conn->error;
        }
    } else {
        echo "Invalid status.";
    }
    $conn->close();
} else {
    echo "Invalid request.";
}
?>