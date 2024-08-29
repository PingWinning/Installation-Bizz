<?php
// Include the database configuration
include('includes/config.php');

// Check if the sanitizeInput function already exists
if (!function_exists('sanitizeInput')) {
    function sanitizeInput($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }
}

// Initialize variables to store form data and error messages
$name = $email = $phone = $message = "";
$nameErr = $emailErr = $phoneErr = $messageErr = "";
$successMsg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isValid = true;

    // Sanitize and validate input
    if (empty($_POST['name'])) {
        $nameErr = "Nom est requis";
        $isValid = false;
    } else {
        $name = sanitizeInput($_POST['name']);
    }

    if (empty($_POST['email'])) {
        $emailErr = "Email est requis";
        $isValid = false;
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Format de l'email invalide";
        $isValid = false;
    } else {
        $email = sanitizeInput($_POST['email']);
    }

    if (empty($_POST['phone'])) {
        $phoneErr = "Téléphone est requis";
        $isValid = false;
    } elseif (!preg_match("/^[0-9]{10,20}$/", $_POST['phone'])) {
        $phoneErr = "Format du numéro de téléphone invalide";
        $isValid = false;
    } else {
        $phone = sanitizeInput($_POST['phone']);
    }

    if (empty($_POST['message'])) {
        $messageErr = "Message est requis";
        $isValid = false;
    } else {
        $message = sanitizeInput($_POST['message']);
    }

    if ($isValid) {
        // Prepare to insert data into the tickets table
        $status = 'pending'; // Set the default status
        $submission_date = date('Y-m-d'); // Current date

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO tickets (name, phone, email, request, status, submission_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $phone, $email, $message, $status, $submission_date);

        // Execute the statement
        if ($stmt->execute()) {
            $successMsg = "Votre demande a été soumise avec succès.";
            // Clear form data after successful submission
            $name = $email = $phone = $message = "";
        } else {
            $successMsg = "Erreur: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services d'Installation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar with Language Toggle -->
    <nav class="bg-gray-800 p-5 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold" id="main-title">Services Professionnels d'Installation</h1>
            <p class="text-gray-400 mt-2" id="subtitle">Votre partenaire de confiance pour une installation sans tracas</p>
        </div>
        <div class="flex items-center">
            <span class="mr-2 text-white">FR</span>
            <div class="switch-container">
                <input type="checkbox" id="switch" class="switch-input">
                <label for="switch" class="switch-label">
                    <span class="switch-circle"></span>
                </label>
            </div>
            <span class="ml-2 text-white">EN</span>
        </div>
    </nav>

    <!-- Description Section -->
    <section class="p-6 text-center">
        <div class="container mx-auto">
            <!-- French Description -->
            <p id="description-fr" class="text-xl mb-6">
                Nous offrons des services d'installation de vos équipements, qu'il s'agisse de supports pour laveuse, sécheuse, ou de l'installation de votre tour sécheuse-laveuse avec le kit de superposition fourni par vos soins. Nous installons également vos téléviseurs sur des supports muraux ou directement sur le mur de votre choix. De plus, nous nous chargeons du retrait et du recyclage des boîtes. Nous assurons l'installation et le branchement de vos canapés sectionnels, que ce soit pour les descendre dans votre sous-sol ou les monter dans votre salon. Nous proposons également des services d'installation de fours, réfrigérateurs, micro-ondes, et d'autres appareils électroménagers. Nos services de déménagement couvrent Laval et Montréal. Pour des déménagements à plus grande distance, des frais supplémentaires peuvent s'appliquer.
            </p>
            <!-- English Description -->
            <p id="description-en" class="text-xl mb-6 hidden">
                We offer installation services for your equipment, whether it's stands for your washer, dryer, or the installation of your washer-dryer tower with the stacking kit provided by you. We also install your televisions on wall mounts or directly on the wall of your choice. Additionally, we handle the removal and recycling of boxes. We ensure the installation and connection of your sectional sofas, whether it’s bringing them down to your basement or up to your living room. We also provide installation services for ovens, refrigerators, microwaves, and other appliances. Our moving services cover Laval and Montreal. For moves to greater distances, additional fees may apply.
            </p>
        </div>
    </section>

    <!-- Services Section -->
    <section class="p-6">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center" id="services-title">Nos Services</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-1-title" class="text-xl font-semibold mb-3">Assemblage de Meubles</h3>
                    <p id="service-1-desc">Nous assemblons avec expertise tous types de meubles, en veillant à ce que tout soit sécurisé et prêt à l'emploi.</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-2-title" class="text-xl font-semibold mb-3">Installation de Téléviseurs</h3>
                    <p id="service-2-desc">Notre équipe monte en toute sécurité votre téléviseur intelligent sur n'importe quel mur, optimisant ainsi votre expérience de visionnage.</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-3-title" class="text-xl font-semibold mb-3">Branchement de Canapés</h3>
                    <p id="service-3-desc">Nous connectons et configurons les canapés modulaires pour qu'ils s'adaptent parfaitement à votre espace et à votre style de vie.</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-4-title" class="text-xl font-semibold mb-3">Ouverture & Recyclage de Boîtes</h3>
                    <p id="service-4-desc">Nous nous occupons de la tâche fastidieuse du déballage et du recyclage, laissant votre espace propre et bien organisé.</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-5-title" class="text-xl font-semibold mb-3">Installations d'Électroménagers</h3>
                    <p id="service-5-desc">Nous installons vos fours, réfrigérateurs, micro-ondes, et autres appareils avec précision et soin.</p>
                </div>
                <div class="bg-gray-800 p-5 rounded-lg">
                    <h3 id="service-6-title" class="text-xl font-semibold mb-3">Services de Déménagement</h3>
                    <p id="service-6-desc">Nous offrons des services de déménagement professionnels à Laval et Montréal. Pour des distances plus longues, des frais supplémentaires peuvent s'appliquer.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="p-6 bg-gray-800">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold mb-6 text-center" id="contact-title">Contactez-Nous</h2>
            
            <!-- Display Success Message -->
            <?php if (!empty($successMsg)) { echo "<p class='text-center text-green-500'>$successMsg</p>"; } ?>
            
            <form class="max-w-lg mx-auto" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-2" for="name">Nom</label>
                    <input class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" placeholder="Votre Nom" required>
                    <span class="text-red-500 text-sm"><?php echo $nameErr; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-2" for="email">Email</label>
                    <input class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Votre Email" required>
                    <span class="text-red-500 text-sm"><?php echo $emailErr; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-2" for="phone">Téléphone</label>
                    <input class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" placeholder="Votre Numéro de Téléphone" required>
                    <span class="text-red-500 text-sm"><?php echo $phoneErr; ?></span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-2" for="message">Message</label>
                    <textarea class="w-full px-4 py-2 bg-gray-900 text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600" id="message" name="message" rows="4" placeholder="Comment pouvons-nous vous aider ?" required><?php echo htmlspecialchars($message); ?></textarea>
                    <span class="text-red-500 text-sm"><?php echo $messageErr; ?></span>
                </div>
                <div class="text-center">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-500 transition duration-300" type="submit">Envoyer</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer Section -->
   <!-- Footer Section -->
    <footer class="bg-gray-900 p-8 text-white">
        <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Business Info -->
            <div>
                <h3 class="text-xl font-bold mb-2">Professional Installation Services</h3>
                <p>We offer top-notch installation services, including furniture assembly, TV mounting, and more. Contact us to experience professional and efficient service. - Nous offrons des services d'installation de première qualité, y compris l'assemblage de meubles, la fixation de téléviseurs, et bien plus encore. Contactez-nous pour bénéficier d'un service professionnel et efficace.</p>
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
        <p class="text-center text-gray-500 mt-8">&copy; 2024 Professional Installation Services. All rights reserved.</p>
    </footer>


    <script src="js/script.js"></script>
</body>
</html>
