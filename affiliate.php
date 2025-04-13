<?php
session_start();
include('includes/config.php');

// Helper function to sanitize input
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data)
    {
        return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
    }
}

// Helper function to normalize phone number into +1 (XXX) XXX-XXXX
function normalizePhone($phone)
{
    $digits = preg_replace('/\D/', '', $phone); // Remove non-digits

    // Match formats like 5141231234 or 15141231234 or +15141231234
    if (preg_match('/^(1)?(\d{3})(\d{3})(\d{4})$/', $digits, $matches)) {
        $area = $matches[2];
        $first = $matches[3];
        $last = $matches[4];
        return "+1 ($area) $first-$last";
    }

    // Fallback: return cleaned digits
    return $phone;
}

// Display messages if any
$successMessage = $_SESSION['successMessage'] ?? '';
$errorMessage = $_SESSION['errorMessage'] ?? '';
unset($_SESSION['successMessage'], $_SESSION['errorMessage']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = isset($_POST['fname']) ? sanitizeInput($_POST['fname']) : '';
    $lname = isset($_POST['lname']) ? sanitizeInput($_POST['lname']) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $rawPhone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $phone = normalizePhone($rawPhone);

    // Validate required fields
    if (empty($fname) || empty($lname) || empty($email)) {
        $_SESSION['errorMessage'] = "Please fill in all required fields.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM affiliates WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['errorMessage'] = "This email is already registered.";
        } else {
            $stmt->close();

            // Insert new affiliate
            $stmt = $conn->prepare("INSERT INTO affiliates (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fname, $lname, $email, $phone);
            if ($stmt->execute()) {
                $_SESSION['successMessage'] = "Thank you for joining the affiliate program!";
            } else {
                $_SESSION['errorMessage'] = "An error occurred. Please try again.";
            }
        }
        $stmt->close();
    }

    // Redirect to prevent resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickFix Brothers - Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/iphone.css">
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="w-full bg-gray-800 py-4 px-6 flex justify-between items-center shadow-md">
        <h1 class="text-xl sm:text-2xl font-bold text-green-400">QuickFix Brothers</h1>

        <!-- Menu Mobile Button -->
        <button id="menu-btn" class="md:hidden text-white focus:outline-none">
            ☰
        </button>

        <!-- Navigation Links -->
        <ul id="menu"
            class="hidden md:flex space-x-6 absolute md:static top-16 left-0 w-full md:w-auto bg-gray-800 md:bg-transparent md:flex-row flex-col md:items-center text-center md:text-left shadow-md md:shadow-none">
            <li><a href="index.php" class="block text-gray-300 hover:text-green-400 py-2 md:py-0 ml-8">Home</a></li>
            <li><a href="#AffiliateProgram" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">Affiliate
                    Program</a></li>
            <li><a href="#HowItWorks" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">How It Works</a>
            </li>
            <li><a href="#contactus" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">Contact</a></li>
        </ul>
    </nav>

    <!-- Title & Inspirational Section -->
    <section class="text-center mt-6 sm:mt-8 px-4" id="AffiliateProgram">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-green-400">
            Heavy Lifting? We Make It Light Work.
        </h1>
        <p class="text-base sm:text-lg text-gray-300 max-w-2xl mx-auto mt-4 px-2">
            Join the <span class='text-green-400 font-semibold'>QuickFix Brothers Affiliate Program</span> and <span
                class='text-green-400 font-semibold'>earn while you move.</span> Whether it’s furniture, home
            installations, or logistics, we help you <span class='text-green-400 font-semibold'>turn hard work into
                smart money.</span>
        </p>
    </section>

    <!-- Content Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col lg:flex-row items-center justify-between">
        <!-- Text & Form Section -->
        <div class="lg:w-1/2 space-y-6 text-center lg:text-left">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-green-400">Money Moves. Let’s Win Together.</h1>
            <p class="text-base sm:text-lg text-gray-300">
                Join QuickFix Brothers and turn every connection into cash. This isn’t just about making money—it’s
                about creating wealth, building success, and helping each other rise.
            </p>
            <p class="text-md sm:text-lg text-gray-400 italic">
                Sign up today and be part of a movement where success is shared, and everyone wins.
            </p>

            <!-- Form -->
            <?php if ($successMessage || $errorMessage): ?>
                <script>
                    window.onload = () => {
                        const modal = document.getElementById("messageModal");
                        const modalTitle = document.getElementById("modalTitle");
                        const modalBody = document.getElementById("modalBody");

                        const type = <?= $successMessage ? "'success'" : "'error'" ?>;
                        const titleText = <?= json_encode($successMessage ?: $errorMessage) ?>;

                        modal.classList.remove("hidden");
                        modalTitle.textContent = titleText;

                        if (type === 'success') {
                            modalTitle.classList.add("text-green-400");
                            modalBody.textContent = "Thanks for submitting your information. A QuickFix Brothers representative will contact you shortly.";
                        } else {
                            modalTitle.classList.add("text-red-400");
                            modalBody.textContent = "There was an issue with your submission. Please verify your inputs and try again.";
                        }
                    };
                </script>
            <?php endif; ?>

            <div id="messageModal"
                class="hidden fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
                <div
                    class="bg-gray-900 rounded-xl shadow-2xl w-full max-w-md p-6 text-center relative border border-gray-700">
                    <button onclick="document.getElementById('messageModal').classList.add('hidden')"
                        class="absolute top-3 right-4 text-gray-400 hover:text-white text-xl">&times;</button>
                    <h2 id="modalTitle" class="text-2xl font-bold mb-4"></h2>
                    <p id="modalBody" class="text-gray-300 text-base leading-relaxed"></p>
                </div>
            </div>

            <form id="affiliateForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
                class="bg-gradient-to-b from-gray-900 to-gray-800 shadow-2xl rounded-2xl p-6 sm:p-8 w-full max-w-md mx-auto lg:mx-0 border border-gray-700">
                <div class="flex flex-col sm:flex-row sm:space-x-4 mb-4">
                    <input type="text" name="fname" placeholder="First Name"
                        class="w-full sm:w-1/2 p-3 border border-gray-700 rounded-xl bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input type="text" name="lname" placeholder="Last Name"
                        class="w-full sm:w-1/2 p-3 border border-gray-700 rounded-xl bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400 mt-4 sm:mt-0">
                </div>
                <input type="email" name="email" placeholder="Email"
                    class="w-full p-3 border border-gray-700 rounded-xl mb-4 bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <input type="tel" name="phone" placeholder="Phone (Optional)"
                    class="w-full p-3 border border-gray-700 rounded-xl mb-4 bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <button type="submit"
                    class="w-full bg-green-500 text-black font-semibold p-4 rounded-3xl hover:bg-green-600 transition text-lg shadow-lg">
                    Join the Movement
                </button>
            </form>

            <script>
                const phoneInput = document.querySelector('input[name="phone"]');

                phoneInput.addEventListener('input', function (e) {
                    e.target.value = e.target.value.replace(/[^\d]/g, '');
                });

                phoneInput.addEventListener('blur', function (e) {
                    let digits = e.target.value.replace(/\D/g, '');

                    if (digits.length === 10) {
                        const area = digits.slice(0, 3);
                        const mid = digits.slice(3, 6);
                        const last = digits.slice(6);
                        e.target.value = `+1 (${area}) ${mid}-${last}`;
                        e.target.setCustomValidity('');
                    } else if (digits.length === 11 && digits.startsWith('1')) {
                        const area = digits.slice(1, 4);
                        const mid = digits.slice(4, 7);
                        const last = digits.slice(7);
                        e.target.value = `+1 (${area}) ${mid}-${last}`;
                        e.target.setCustomValidity('');
                    } else if (digits.length === 0) {
                        e.target.value = '';
                        e.target.setCustomValidity('');
                    } else {
                        e.target.setCustomValidity('Invalid format. Use: +1 (514) 123-1234');
                        e.target.reportValidity();
                    }
                });
            </script>
        </div>

        <!-- iPhone Display Section -->
        <div class="mt-4 lg:w-1/2 flex justify-center">
            <div class="iphone-frame">
                <div class="iphone-notch"></div>
                <div class="chat-box" id="chatBox"></div>
            </div>
        </div>
    </div>


    <div class="relative flex flex-col md:flex-row justify-between items-center w-full max-w-6xl mx-auto px-4 sm:px-12">
        <!-- Text Section -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h2 class="text-3xl sm:text-5xl font-extrabold text-green-400 mb-6 leading-tight">
                Your&nbsp;Network. <br class="hidden sm:block"> Your&nbsp;Power. <br class="hidden sm:block">
                Your&nbsp;Opportunity.
            </h2>
            <p class="text-lg sm:text-2xl text-gray-300 max-w-lg mx-auto md:mx-0 mb-6 leading-relaxed">
                No matter where you are, you can build wealth. <br class="hidden sm:block">
                Connect. Refer. Earn. It’s that simple.
            </p>
            <p class="text-md sm:text-xl text-gray-400 max-w-lg mx-auto md:mx-0 mb-6">
                We welcome affiliates worldwide—your success isn’t limited by location. 📍🌎
                Your referrals connect with clients primarily in
                <span class="font-semibold">Montreal, Laval, and nearby regions</span>.
                Services beyond this area may involve additional costs, but your commission remains the same.
            </p>
            <p class="text-md sm:text-xl text-gray-400 max-w-lg mx-auto md:mx-0">
                Get paid your way: <span class="text-green-400 font-semibold">PayPal, Revolut, e-Transfer.</span><br
                    class="hidden sm:block">
                No waiting. No hassle. Just real earnings, anywhere in the world.
            </p>
        </div>

        <!-- Image/Icon Section -->
        <div class="w-full md:w-1/2 flex justify-center">
            <span class="text-[250px] sm:text-[300px] md:text-[400px]">🌎</span>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col lg:flex-row items-center justify-between"
        id="HowItWorks">
        <!-- Text & Form Section -->
        <!-- Text & Inspirational Message Section -->
        <div class="lg:w-1/2 space-y-6 text-center lg:text-left">
            <h1 class="text-4xl sm:text-6xl font-extrabold text-green-400 leading-tight">
                Earn Without Limits. <br class="hidden sm:block" /> Grow With Every Connection.
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 max-w-xl">
                Every client you bring is a step forward — for you, for them, for all of us.
                No caps. No ceilings. Just potential.
            </p>
            <div class="max-w-md sm:max-w-lg mx-auto">
                <ul class="space-y-4 text-white text-lg sm:text-xl font-medium">
                    <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">📦</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">$120</span>
                                <span class="text-green-400 font-extrabold">Small Move</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(within&nbsp;Montreal/Laval)</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">🏠</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">$200</span>
                                <span class="text-green-400 font-extrabold">Larger Move</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(within&nbsp;Montreal/Laval)</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">📍</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">$250</span>
                                <span class="text-green-400 font-extrabold">Long Distance Move</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(Outside&nbsp;Montreal/Laval)</span>
                    </li>
                </ul>
            </div>

            <p class="text-md sm:text-lg text-gray-400 italic">
                QuickFix Brothers — A community built on trust, driven by growth, and powered by you.
            </p>
        </div>


        <!-- iPhone Display Section -->
        <div class="mt-4 lg:w-1/2 flex justify-center">
            <div class="iphone-frame">
                <div class="iphone-notch"></div>
                <div class="balance-container">
                    <p class="balance-label">Current Balance</p>
                    <div id="balance" class="balance">$0.00</div>
                </div>

                <div id="transactions" class="transactions"></div>

                <button class="cta-button">Cash out!!!</button>
            </div>
        </div>
    </div>

    <section class="max-w-full mx-auto px-6 sm:px-12 py-12">
        <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-center text-green-400 mb-6">
            Your Hustle. Your Legacy.
        </h2>
        <p class="text-gray-400 text-center max-w-4xl mx-auto mb-12 text-lg sm:text-xl">
            This isn’t just another gig. This is your chance to build real wealth through your connections.
            At QuickFix Brothers, we turn hard work into success. Are you ready to claim your share?
        </p>

        <!-- ✅ Fix: 2 cartes sur tablettes (md:grid-cols-2), 1 carte sur mobile, 4 cartes sur desktop -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">

            <!-- Card 1 - Work When You Want -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">🚀</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Work When You Want</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        No schedules. No pressure.
                        Work <span class="text-green-400 font-semibold">part-time or full-time</span>, at your own pace.
                        Whether you're a student, entrepreneur, or full-time worker,
                        this opportunity <span class="text-green-400 font-semibold">adapts to you</span>.
                    </p>
                </div>
            </div>

            <!-- Card 2 - Unlimited Earnings -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">💰</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Unlimited Earnings</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        The more you refer, the more you earn.
                        <span class="text-green-400 font-semibold">No limits.</span>
                        Whether it's passive income or a full-time gig,
                        <span class="text-green-400 font-semibold">your effort defines your success</span>.
                    </p>
                </div>
            </div>

            <!-- Card 3 - Work From Anywhere -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">🌍</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Work From Anywhere</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Your income isn’t tied to an office.
                        Work from home, a café, or even while traveling.
                        <span class="text-green-400 font-semibold">This opportunity follows you.</span>
                    </p>
                </div>
            </div>

            <!-- Card 4 - Instant Payments -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">⚡</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Instant Payments</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Get paid <span class="text-green-400 font-semibold">instantly</span>.
                        Choose between <span class="text-green-400 font-semibold">PayPal, Revolut, or e-Transfer</span>.
                        No waiting. No delays. <span class="text-green-400 font-semibold">Just real earnings.</span>
                    </p>
                </div>
            </div>

        </div>
    </section>

    <footer id="contactus" class="bg-gray-900 p-8 text-white w-full">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Business Info -->
            <div>
                <h3 class="text-xl font-bold mb-2">Professional Installation Services</h3>
                <p>We offer top-notch installation services, including furniture assembly, TV mounting, and more.
                    Contact us to experience professional and efficient service. - Nous offrons des services
                    d'installation de première qualité, y compris l'assemblage de meubles, la fixation de téléviseurs,
                    et bien plus encore. Contactez-nous pour bénéficier d'un service professionnel et efficace.</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-rss"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-pinterest"></i></a>
                </div>
            </div>

            <!-- Opening Time -->
            <div>
                <h3 class="text-xl font-bold mb-2">Opening Time</h3>
                <table class="table-auto w-full text-left">
                    <tbody>
                        <tr>
                            <td class="py-2">Monday-Friday:</td>
                            <td class="py-2 text-right">08:00 To 22:00</td>
                        </tr>
                        <tr>
                            <td class="py-2">Saturday:</td>
                            <td class="py-2 text-right">08:00 To 22:00</td>
                        </tr>
                        <tr>
                            <td class="py-2">Sunday:</td>
                            <td class="py-2 text-right">10:00 To 22:00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Contact Information -->
            <div>
                <h3 class="text-xl font-bold mb-2">Information</h3>
                <p><i class="fas fa-map-marker-alt"></i> Montreal, Laval</p>
                <p><i class="fas fa-phone-alt"></i> Montreal: (514) 578-2382</p>
                <p><i class="fas fa-phone-alt"></i> Laval: (514) 689-1531</p>
                <p><i class="fas fa-envelope"></i> InstallationServices@gmail.com</p>
            </div>
        </div>

        <!-- Truck Animation -->
        <div class="loop-wrapper">
            <div class="mountain"></div>
            <div class="hill"></div>
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="tree"></div>
            <div class="rock"></div>
            <div class="truck"></div>
            <div class="wheels"></div>
        </div>

        <p class="text-center text-gray-500 mt-8">&copy; <span id="year"></span> QuickFix Brothers Professional
            Installation Services. All rights reserved.</p>
        <script>
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    </footer>

    <script src="js/iphone.js"></script>
    <script>
        document.getElementById("menu-btn").addEventListener("click", function () {
            document.getElementById("menu").classList.toggle("hidden");
        });
    </script>
</body>

</html>