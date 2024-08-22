<?php
include_once('../includes/config.php');

// Your login logic here...
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = sanitizeInput($_POST["username"]);
    $pass = sanitizeInput($_POST["password"]);

    // SQL injection prevention using prepared statements
    $stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash);
        $stmt->fetch();

        // Verify the password
        if (hash("sha256", $pass) === $password_hash) {
            $_SESSION['username'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    } else {
        $error = "Incorrect username or password.";
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
    <div class="wrapper">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h2>Login</h2>
            <?php if (!empty($error)) { echo "<div class='error' style='color: red;'>$error</div>"; } ?>
            <div class="input-field">
                <input type="text" name="username" required>
                <label>Enter your username</label>
            </div>
            <div class="input-field">
                <input type="password" name="password" required>
                <label>Enter your password</label>
            </div>
            <button type="submit">Log In</button>
        </form>
    </div>
    <script src="../js/stars.js"></script>
</body>
</html>
