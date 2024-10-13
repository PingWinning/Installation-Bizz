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
   <section class="p-6 text-center bg-gray-900 text-white">
        <div class="container mx-auto">
            <!-- French Description -->
            <div class="mb-6" id="description-fr">
                <h3 class="text-xl font-semibold mb-3">Nos Services</h3>
                <div>
                    <p class="text-lg md:text-xl leading-relaxed text-justify">
                        Chez QuickFix Brothers, nous offrons des services d'installation de première qualité pour tous vos besoins. Que ce soit pour installer des supports pour votre laveuse et sécheuse, monter votre tour laveuse-sécheuse avec un kit d'empilage, ou fixer votre télévision au mur idéal, nous sommes là pour vous. Nous prenons également soin des petits détails, comme le retrait et le recyclage des cartons, et nous nous assurons que votre canapé sectionnel est parfaitement placé, que ce soit au sous-sol ou dans le salon. Besoin d’installer votre four, réfrigérateur, micro-ondes ou d’autres appareils ? Considérez cela comme fait. De plus, nous offrons des services de déménagement fiables à Laval et Montréal, avec des options pour de plus longues distances également.
                    </p>
                </div>

                <h3 class="text-xl font-semibold mt-3 mb-3">Et Plus Encore</h3>
                <div>
                    <p class="text-lg md:text-xl leading-relaxed text-justify">
                        Si vous ne voyez pas un service spécifique dans notre liste, ou si vous avez des préoccupations, n’hésitez pas à nous contacter. Nous sommes toujours prêts à adapter nos services pour répondre à vos besoins.
                    </p>
                </div>

                <h3 class="text-xl font-semibold mb-3">Pourquoi Nous Choisir ?</h3>
                <div>
                    <p class="text-lg md:text-xl leading-relaxed text-justify">
                        Imaginez une histoire qui commence il y a des années, deux frères, un atelier, et une passion inébranlable pour l’art de l’assemblage.
                        <span id="dots-fr">...</span><span id="more-fr" class="hidden"> Mon frère et moi avons passé des années à travailler pour de grandes entreprises de meubles et de fournitures, ces monopoles où les clients n’ont souvent pas d’autre choix que de recourir à leurs installateurs. Combien de fois avons-nous entendu les récits de clients déçus par ces grandes entreprises, frustrés par des installateurs pressés, des travaux bâclés, ou tout simplement par un manque de temps et d’attention ?
                        <br><br>
                        C’est de là qu’est née notre entreprise. Ce n’est pas seulement un travail pour nous, c’est une mission. Chaque vis que nous serrons, chaque meuble que nous montons, chaque télé que nous accrochons est un acte de confiance entre vous et nous. Avec nous, vous n’êtes pas simplement un client ; vous devenez une partie de notre histoire, de notre aventure. Nous sommes une petite équipe, et c’est là notre force. Nous travaillons en parfaite harmonie pour garantir que le travail est fait comme il se doit, avec un souci du détail que vous ne trouverez nulle part ailleurs.
                        <br><br>
                        Les grandes entreprises ? Elles sont submergées, jonglent avec trop de clients, pressées par le temps, et souvent leurs employés sont sous-payés. Mais pas nous. Chaque mission est une œuvre unique, et nous sommes déterminés à prouver que la qualité et l’attention personnelle sont toujours d’actualité. Avec nous, vous faites partie d’un récit où chaque geste compte, où votre satisfaction est notre plus grande récompense.</span>
                    </p>
                    <a class="cursor-pointer" onclick="toggleText('fr')" id="toggleText-fr">voir plus</a>
                </div>
            </div>

            <!-- English Description -->
            <div class="mb-6 hidden" id="description-en">
                <h3 class="text-xl font-semibold mb-3">Our Services</h3>
                <p class="text-lg md:text-xl leading-relaxed text-justify">
                    At QuickFix Brothers, we offer top-notch installation services for all your needs. Whether you're looking to install a washer and dryer stand, set up your washer-dryer tower with a stacking kit, or securely mount your TV on the perfect wall, we’ve got you covered. We take care of the small details too, from removing and recycling boxes to ensuring that your sectional sofa is perfectly placed, whether it’s in the basement or the living room. Need to install your oven, refrigerator, microwave, or other appliances? Consider it done. Plus, we offer reliable moving services across Laval and Montreal, with options for long-distance moves as well.
                </p>
                <h3 class="text-xl font-semibold mt-3 mb-3">And Much More</h3>
                <p class="text-lg md:text-xl leading-relaxed text-justify">
                    If you don’t see a specific service listed or have special concerns, don’t hesitate to contact us. We're always ready to customize our services to meet your unique needs.
                </p>
                <h3 class="text-xl font-semibold mb-3">Why Choose Us?</h3>
                <div>
                    <p class="text-lg md:text-xl leading-relaxed text-justify">
                        Imagine a story that began years ago, with two brothers, a workshop, and an unwavering passion for the art of assembly.
                        <span id="dots-en">...</span><span id="more-en" class="hidden"> My brother and I spent years working for large furniture and appliance companies – those monopolies where clients often had no choice but to rely on their installers. How many times did we hear stories of clients let down by these big companies, frustrated with rushed installers, sloppy work, or simply a lack of care and attention?
                        <br><br>
                        That’s how our company was born. This isn’t just a job for us; it’s a mission. Every screw we tighten, every piece of furniture we assemble, every TV we mount represents a bond of trust between you and us. With us, you’re not just a client; you become part of our story, part of our adventure. We are a small team, and that’s our strength. We work in perfect harmony to ensure the job is done right, with attention to detail that you won’t find anywhere else.
                        <br><br>
                        Big companies? They’re overwhelmed, juggling too many clients, racing against time, and often underpaying their employees. But not us. Every task is a unique piece of work, and we’re committed to proving that quality and personal attention are still very much alive. With us, you’re part of a narrative where every action counts, where your satisfaction is our greatest reward.</span>
                    </p>
                    <a class="cursor-pointer" onclick="toggleText('en')" id="toggleText-en">see more</a>
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
