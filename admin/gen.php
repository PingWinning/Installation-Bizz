<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include_once('../includes/config.php');

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function generateSalt($length = 16) {
    return bin2hex(random_bytes($length)); // Cryptographically secure salt
}

function hashPassword($password, $salt) {
    return hash('sha256', $salt . $password); // Hash password with salt
}

// Example registration data
$username = "Boss007";
$password = "pass";

// Generate salt and hash the password
$salt = generateSalt();
$hashedPassword = hashPassword($password, $salt);

// Debug outputs
echo "Generated Salt: $salt<br>";
echo "Hashed Password: $hashedPassword<br>";

// Save salt and hashed password to the database
$stmt = $conn->prepare("INSERT INTO users (username, password_hash, salt) VALUES (?, ?, ?)");
if ($stmt) {
    $stmt->bind_param("sss", $username, $hashedPassword, $salt);
    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error executing statement: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
