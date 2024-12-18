<?php
include_once('../includes/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = htmlspecialchars(trim($_POST["username"]));
    $pass = htmlspecialchars(trim($_POST["password"]));

    // Fetch hashed password and salt for the user
    $stmt = $conn->prepare("SELECT id, password_hash, salt FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password_hash, $salt);
        $stmt->fetch();

        // Verify password with the stored salt
        if (hash('sha256', $salt . $pass) === $password_hash) {
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
    <title>Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...hash..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        input:focus {
            outline: none;
            box-shadow: 0 0 8px #3b82f6;
        }
    </style>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            }
        }
    </script>
</head>
<body class="bg-gray-900 flex justify-center items-center min-h-screen">
    <div class="bg-gray-800 text-white p-8 rounded-lg shadow-2xl w-full max-w-md">
        <!-- Logo Section -->
        <div class="flex justify-center mb-6">
            <div class="text-center">
                <span class="text-4xl font-bold text-blue-500">Admin Panel</span>
                <p class="text-gray-400 mt-2 text-sm">Secure Login for Administrators</p>
            </div>
        </div>

        <!-- Login Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <?php if (!empty($error)): ?>
                <div class="mb-4 text-red-400 text-sm text-center"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Username Field -->
            <div class="mb-6">
                <label for="username" class="block text-gray-300 mb-2">Username</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required
                    class="w-full p-3 rounded-lg bg-gray-700 text-white focus:ring focus:ring-blue-500 transition duration-300">
            </div>
            
            <!-- Password Field with Eye Icon -->
            <div class="mb-6 relative">
                <label for="password" class="block text-gray-300 mb-2">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required
                    class="w-full p-3 rounded-lg bg-gray-700 text-white focus:ring focus:ring-blue-500 transition duration-300">
                <span class="absolute right-4 top-10 text-gray-400 cursor-pointer" onclick="togglePassword()">
                    <i id="togglePasswordIcon" class="fas fa-eye-slash"></i>
                </span>
            </div>
            
            <!-- Login Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-md">
                    Login
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-xs">
            <p>&copy; <span id="year"></span> QuickFix Brothers Admin Panel. All Rights Reserved.</p>
        </div>
    </div>
    <script src="../js/stars.js"></script>
</body>
</html>
