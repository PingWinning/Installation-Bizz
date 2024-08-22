<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include the database configuration
include('../includes/config.php');

// Check if a POST request is made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the ticket ID and status from the POST request
    $ticket_id = intval($_POST['ticket_id']);
    $status = $_POST['status'];
    
    // Prepare and execute the update query
    $stmt = $conn->prepare("UPDATE tickets SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $ticket_id);
    
    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
