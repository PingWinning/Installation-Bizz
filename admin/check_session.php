<?php
session_start();

// Define session timeout duration (15 minutes = 900 seconds)
$timeout_duration = 900;
$response = ["status" => "active"];

// Ensure 'last_activity' is set before accessing it
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time(); // Initialize session timestamp if not set
}

// Calculate elapsed time
$elapsed_time = time() - $_SESSION['last_activity'];

if ($elapsed_time >= $timeout_duration) {
    session_unset();
    session_destroy();
    $response["status"] = "expired"; // Tell AJAX to redirect the user
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
?>
