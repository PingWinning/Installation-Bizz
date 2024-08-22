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
    // Get the ticket ID from the POST request
    $ticket_id = intval($_POST['ticket_id']);
    
    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM tickets WHERE id = ?");
    $stmt->bind_param("i", $ticket_id);
    
    if ($stmt->execute()) {
        // Redirect back to the index page
        header("Location: index.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
