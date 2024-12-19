<?php
include_once('../includes/config.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login.php if required session variables are not set
if (!isset($_SESSION['otp_user_id']) || !isset($_SESSION['temp_username'])) {
    header("Location: login.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp = implode("", array_map("htmlspecialchars", $_POST['otp']));
    $user_id = $_SESSION['otp_user_id'];

    // Fetch stored OTP and expiry for the user
    $stmt = $conn->prepare("SELECT otp, otp_expiry FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($stored_otp, $otp_expiry);
    $stmt->fetch();
    $stmt->close();

    // Validate OTP
    if ($stored_otp === $otp && strtotime($otp_expiry) > time()) {
        // OTP is valid, login the user
        unset($_SESSION['otp_user_id']); // Remove OTP-related session
        $_SESSION['username'] = $_SESSION['temp_username']; // Set the username session
        unset($_SESSION['temp_username']); // Remove temporary username session
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid or expired OTP.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
            border: 2px solid #ccc;
            border-radius: 5px;
            margin: 0 5px;
            outline: none;
            transition: border-color 0.3s ease;
            color: black;
        }
        .otp-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 5px #2563eb;
        }
    </style>
    <script>
        function moveToNextInput(event, nextInputId) {
            if (event.target.value.length === 1 && nextInputId) {
                document.getElementById(nextInputId).focus();
            }
        }

        function moveToPreviousInput(event, prevInputId) {
            if (event.key === "Backspace" && event.target.value.length === 0 && prevInputId) {
                document.getElementById(prevInputId).focus();
            }
        }
    </script>
</head>
<body class="bg-gray-900 flex justify-center items-center min-h-screen">
    <div class="bg-gray-800 text-white p-8 rounded-lg shadow-2xl w-full max-w-md">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="text-center">
            <h2 class="text-2xl font-bold mb-6">Verify OTP</h2>
            <?php if (!empty($error)): ?>
                <div class="mb-4 text-red-400 text-sm"><?php echo $error; ?></div>
            <?php endif; ?>
            <div class="flex justify-center mb-6">
                <?php for ($i = 0; $i < 6; $i++): ?>
                    <input type="text" id="otp<?php echo $i; ?>" name="otp[]" maxlength="1" class="otp-input"
                        oninput="moveToNextInput(event, '<?php echo $i < 5 ? 'otp' . ($i + 1) : ''; ?>')"
                        onkeydown="moveToPreviousInput(event, '<?php echo $i > 0 ? 'otp' . ($i - 1) : ''; ?>')" required>
                <?php endfor; ?>
            </div>
            <button type="submit"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition-all duration-300 shadow-md">
                Verify
            </button>
        </form>
    </div>
</body>
</html>
