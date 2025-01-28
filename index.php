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
    <title>QuickFix Brothers | Handyman Services in Montreal & Laval</title>
    <meta name="description" content="Service de déménagement professionnel à Montréal et Laval. Réservez dès maintenant pour juin. Aide rapide et efficace pour déménagement résidentiel ou commercial, avec montage et démontage de meubles inclus.">
    <meta name="keywords" content="Déménagement Montréal, Déménagement Laval, Service de déménagement, Réservation déménagement juin, Aide au déménagement, Handyman déménagement, Petit déménagement, Prix abordables déménagement">
    <meta name="description" content="QuickFix Brothers offers reliable handyman services in Montreal and Laval, including furniture assembly, TV installation, sofa setup, appliance installation, snow removal, and more.">
    <meta name="keywords" content="
        handyman Montreal, Laval handyman, 
        handyman services Montreal, handyman services Laval,
        furniture assembly Montreal, furniture assembly Laval,
        patio furniture assembly Montreal, patio furniture assembly Laval, 
        TV installation Montreal, TV installation Laval,
        sofa setup Montreal, sofa setup Laval,
        box opening and recycling Montreal, box opening and recycling Laval,
        appliance installation Montreal, appliance installation Laval,
        fridge installation Montreal, fridge installation Laval,
        microwave installation Montreal, microwave installation Laval,
        oven installation Montreal, oven installation Laval,
        moving services Montreal, moving services Laval,
        home office setup Montreal, home office setup Laval,
        desk assembly Montreal, desk assembly Laval,
        chair assembly Montreal, chair assembly Laval,
        computer setup Montreal, computer setup Laval,
        cable management Montreal, cable management Laval,
        domestic repairs Montreal, domestic repairs Laval,
        door repair Montreal, door repair Laval,
        handle replacement Montreal, handle replacement Laval,
        wall crack repair Montreal, wall crack repair Laval,
        snow removal Montreal, snow removal Laval,
        driveway snow removal Montreal, driveway snow removal Laval,
        garage snow removal Montreal, garage snow removal Laval,
        Stack Kit laundry Montreal, Stack Kit laundry Laval,
        laundry services Montreal, laundry services Laval,
        lawn mowing Montreal, lawn mowing Laval,
        lawn care Montreal, lawn care Laval,
        handyman Laval, handyman Montreal, affordable handyman Montreal, affordable handyman Laval,
        expert handyman Montreal, expert handyman Laval
    ">
    <meta name="author" content="QuickFix Brothers">
    <meta name="robots" content="index, follow">
    <!-- Open Graph for SEO -->
    <meta property="og:title" content="QuickFix Brothers | Handyman Services in Montreal & Laval">
    <meta property="og:description" content="QuickFix Brothers offers handyman services like furniture assembly, TV mounting, and snow removal in Montreal and Laval. Reliable and affordable!">
    <meta property="og:url" content="https://quickfixbrothers.com">
    <meta property="og:type" content="website">
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

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
        <a href="terms-and-conditions.html" class="mr-2">FAQ</a><br>
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

    <!-- Services Section -->
    <section class="p-6">
    <div class="container mx-auto">
        <h1 class="text-4xl font-semibold mb-2 text-center">
            QuickFix Brothers
        </h1>
        <h2 class="text-2xl font-semibold mb-6 text-center" id="services-title">
            <i class="fas fa-tools"></i>&nbsp;Nos Services
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-1-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-couch"></i>&nbsp;Assemblage de Meubles/Patio
                </h3>
                <p id="service-1-desc">Besoin d'aide pour assembler de nouveaux meubles de bureau ou un salon de patio extérieur pour votre nouvelle terrasse ? Engagez-nous pour vous aider à assembler les éléments de vos meubles d'intérieur et d'extérieur.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-2-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-tv"></i>&nbsp;Installation de Téléviseurs
                </h3>
                <p id="service-2-desc">Notre équipe installe en toute sécurité votre téléviseur intelligent sur n'importe quel mur, optimisant ainsi votre expérience de visionnage. Offrez-vous un espace moderne et élégant pour une expérience visuelle améliorée.</p>
                <p id="service-indispo" class="text-sm mt-2 text-center" style="color: red;">Service actuellement indisponible</p>        
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-3-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-couch"></i>&nbsp;Branchement de Canapés
                </h3>
                <p id="service-3-desc">Nous connectons et configurons les canapés modulaires pour qu'ils s'intègrent parfaitement à votre espace. Nous pouvons également vous conseiller sur le choix et l'agencement des canapés et sectionnels, pour un intérieur à la fois pratique et élégant.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-4-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-recycle"></i>&nbsp;Ouverture & Recyclage de Boîtes
                </h3>
                <p id="service-4-desc">Nous nous occupons de la tâche fastidieuse du déballage et du recyclage, laissant votre espace propre et bien organisé. Le respect de l'environnement nous tient à cœur, c'est pourquoi nous recyclons tous les matériaux de manière responsable.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-5-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-blender"></i>&nbsp;Installations d'Électroménagers
                </h3>
                <p id="service-5-desc">Nous installons vos fours, réfrigérateurs, micro-ondes et autres appareils avec précision et soin. Nous nous chargeons également de la livraison de vos électroménagers à domicile, si besoin.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-6-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-truck-moving"></i>&nbsp;Services de Déménagement
                </h3>
                <p id="service-6-desc">Nous offrons des services de déménagement professionnels à Laval et Montréal. Pour des distances plus longues, des frais supplémentaires peuvent s'appliquer.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-7-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-desktop"></i>&nbsp;Configuration de Bureau à Domicile
                </h3>
                <p id="service-7-desc">Nous assistons les clients dans la configuration de bureaux à domicile, y compris l'assemblage de bureaux, de chaises, la mise en place de l'équipement informatique et la gestion des câbles.</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-8-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-wrench"></i>&nbsp;Réparations domestiques
                </h3>
                <p id="service-8-desc">Besoin d'aide pour des réparations à la maison ? Confiez-nous la tâche de fixer vos portes, remplacer des poignées, ou encore réparer les fissures et trous dans vos murs. Notre expertise garantit un travail soigné et rapide, pour que votre maison retrouve tout son éclat en un rien de temps !</p>
            </div>
            <div class="bg-gray-800 p-5 rounded-lg">
                <h3 id="service-9-title" class="text-xl font-semibold mb-3">
                    <i class="fas fa-snowflake"></i>&nbsp;Déneigement d'Entrée
                </h3>
                <p id="service-9-desc">Nous offrons des services de déneigement d'entrée et d'entrée de garage pendant l'hiver.</p>
            </div>
        </div>
    </div>
</section>

    <!-- Description Section -->
<section section id="description-fr" class="p-6 bg-gray-600 text-white">
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-center mb-12">
            Pourquoi Choisir <span class="text-yellow-500">QuickFix Brothers ?</span>
        </h1>

        <!-- Features Section -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Transparent Pricing -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Prix Transparents</h2>
                <p class="mt-4 text-gray-400">
                    Aucun frais caché, aucune surprise : seulement <span class="font-bold text-white">$75/heure</span>, pour une transparence totale qui inspire confiance.
                </p>
            </div>

            <!-- Superior Quality -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Qualité Supérieure</h2>
                <p class="mt-4 text-gray-400">
                    Avec QuickFix Brothers, chaque projet est réalisé avec soin et précision. <span class="font-bold text-white">95%</span> de nos clients disent que nous dépassons leurs attentes.
                </p>
            </div>

            <!-- Reliable Efficiency -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Efficacité Fiable</h2>
                <p class="mt-4 text-gray-400">
                    Votre temps est précieux. <span class="font-bold text-white">85%</span> de nos tâches sont accomplies en moins d'une heure, sans compromettre la qualité.
                </p>
            </div>
        </div>

        <!-- Why Us Section -->
        <div class="mt-16 bg-yellow-500 text-gray-900 rounded-lg p-8">
            <h2 class="text-3xl font-bold text-center mb-6">Notre Histoire, Votre Confiance</h2>
            <p class="text-lg leading-8 text-center">
                Imaginez deux frères, un atelier, et une passion pour l’art de l’assemblage. Après des années à travailler pour de grandes entreprises, nous avons décidé de créer une entreprise différente,<strong>une entreprise qui place ses clients au cœur de chaque mission.</strong>
            </p>
            <p class="text-lg leading-8 text-center mt-4">
                Contrairement aux grandes entreprises souvent pressées et débordées, nous prenons le temps de bien faire les choses. Chaque vis que nous serrons et chaque meuble que nous montons sont des symboles de la confiance que vous nous accordez.
            </p>
        </div>

        <!-- Closing Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-4 text-yellow-500">Avec QuickFix Brothers, Chaque Geste Compte</h2>
            <p class="text-lg text-gray-400 text-center leading-8">
                En nous choisissant, vous ne faites pas qu'engager des professionnels ; vous rejoignez une aventure où la satisfaction du client est notre priorité absolue. Faites partie de notre histoire et découvrez la différence d’un service véritablement personnalisé.
            </p>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <p class="text-lg text-gray-400">
                Prêts à transformer vos projets en réalité ? Contactez <span class="text-yellow-500 font-bold">QuickFix Brothers</span> dès aujourd'hui.
            </p>
        </div>
    </div>
</section>
<section id="description-en" class="p-6 bg-gray-600 text-white hidden">
    <div class="container mx-auto">
        <h1 class="text-4xl font-bold text-center mb-12">
            Why Choose <span class="text-yellow-500">QuickFix Brothers?</span>
        </h1>

        <!-- Features Section -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Transparent Pricing -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Transparent Pricing</h2>
                <p class="mt-4 text-gray-400">
                    No hidden fees, no surprises: just <span class="font-bold text-white">$75/hour</span>, ensuring complete transparency you can trust.
                </p>
            </div>

            <!-- Superior Quality -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Superior Quality</h2>
                <p class="mt-4 text-gray-400">
                    At QuickFix Brothers, every project is executed with care and precision. <span class="font-bold text-white">95%</span> of our clients say we exceed their expectations.
                </p>
            </div>

            <!-- Reliable Efficiency -->
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">Reliable Efficiency</h2>
                <p class="mt-4 text-gray-400">
                    Your time is valuable. <span class="font-bold text-white">85%</span> of our tasks are completed in under an hour without compromising quality.
                </p>
            </div>
        </div>

        <!-- Why Us Section -->
        <div class="mt-16 bg-yellow-500 text-gray-900 rounded-lg p-8">
            <h2 class="text-3xl font-bold text-center mb-6">Our Story, Your Trust</h2>
            <p class="text-lg leading-8 text-center">
                Imagine two brothers, a workshop, and an unwavering passion for the art of assembly. After years of working for large companies, we decided to create something different—an <strong>enterprise that puts its clients at the heart of every mission.</strong>
            </p>
            <p class="text-lg leading-8 text-center mt-4">
                Unlike large corporations that are often rushed and overwhelmed, we take the time to do things right. Every screw we tighten and every piece of furniture we assemble symbolizes the trust you place in us.
            </p>
        </div>

        <!-- Closing Section -->
        <div class="mt-16">
            <h2 class="text-3xl font-bold text-center mb-4 text-yellow-500">With QuickFix Brothers, Every Detail Matters</h2>
            <p class="text-lg text-gray-400 text-center leading-8">
                By choosing us, you're not just hiring professionals; you're joining an adventure where client satisfaction is our top priority. Become part of our story and experience the difference of truly personalized service.
            </p>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-12">
            <p class="text-lg text-gray-400">
                Ready to turn your projects into reality? Contact <span class="text-yellow-500 font-bold">QuickFix Brothers</span> today.
            </p>
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
                    <p id="termes" class="text-sm text-gray-400 mt-4">
                        En cliquant sur "Envoyer", vous acceptez nos 
                        <a href="terms-et-conditions.html" class="text-blue-500 hover:underline">termes et conditions</a>.
                    </p>
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

        <p class="text-center text-gray-500 mt-8">&copy; <span id="year"></span> QuickFix Brothers Professional Installation Services. All rights reserved.</p>
    </footer>
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
    <script src="js/script.js"></script>
</body>
</html>
