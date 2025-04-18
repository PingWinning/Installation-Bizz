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
        $_SESSION['errorMessage'] = "Veuillez remplir tous les champs obligatoires.";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM affiliates WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['errorMessage'] = "Cet e-mail est déjà enregistré.";
        } else {
            $stmt->close();

            // Insert new affiliate
            $stmt = $conn->prepare("INSERT INTO affiliates (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $fname, $lname, $email, $phone);
            if ($stmt->execute()) {
                $_SESSION['successMessage'] = "Merci d’avoir rejoint le programme de parrainage !";
            } else {
                $_SESSION['errorMessage'] = "Une erreur s’est produite. Veuillez réessayer.";
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
            <li><a href="index.php" class="block text-gray-300 hover:text-green-400 py-2 md:py-0 ml-8">Accueil</a></li>
            <li><a href="#AffiliateProgram" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">Programme
                    d’affiliation</a></li>
            <li><a href="#HowItWorks" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">Comment ça
                    marche</a></li>
            <li><a href="#contactus" class="block text-gray-300 hover:text-green-400 py-2 md:py-0">Contact</a></li>
        </ul>
    </nav>

    <!-- Title & Inspirational Section -->
    <section class="text-center mt-6 sm:mt-8 px-4" id="AffiliateProgram">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-green-400">
            Les charges sont lourdes. Mais ensemble, on les soulève avec légèreté.
        </h1>
        <p class="text-base sm:text-lg text-gray-300 max-w-2xl mx-auto mt-4 px-2">
            Rejoignez le <span class='text-green-400 font-semibold'>programme d’affiliation QuickFix Brothers</span>
            et <span class='text-green-400 font-semibold'>transformez chaque effort en opportunité.</span>
            Qu’il s’agisse de meubles, d’installations ou de logistique,
            on ne fait pas que bouger — <span class='text-green-400 font-semibold'>on avance, ensemble.</span>
        </p>
    </section>

    <!-- Content Section -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 sm:py-12 flex flex-col lg:flex-row items-center justify-between">
        <!-- Text & Form Section -->
        <div class="lg:w-1/2 space-y-6 text-center lg:text-left">
            <h1 class="text-3xl sm:text-5xl font-extrabold text-green-400">On fait bouger l’argent. Gagnons ensemble.
            </h1>
            <p class="text-base sm:text-lg text-gray-300">
                Rejoignez QuickFix Brothers et transformez chaque contact en revenu. Il ne s’agit pas seulement de
                gagner de l’argent,
                mais de bâtir une vraie richesse, de créer du succès et de s’élever ensemble.
            </p>
            <p class="text-md sm:text-lg text-gray-400 italic">
                Inscrivez-vous dès aujourd’hui et faites partie d’un mouvement où la réussite se partage et où tout le
                monde y gagne.
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
                            modalBody.textContent = "Merci pour votre soumission. Un représentant de QuickFix Brothers vous contactera sous peu.";
                        } else {
                            modalTitle.classList.add("text-red-400");
                            modalBody.textContent = "Une erreur s’est produite lors de l’envoi. Veuillez vérifier vos informations et réessayer.";
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
                    <input type="text" name="fname" placeholder="Prénom"
                        class="w-full sm:w-1/2 p-3 border border-gray-700 rounded-xl bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                    <input type="text" name="lname" placeholder="Nom"
                        class="w-full sm:w-1/2 p-3 border border-gray-700 rounded-xl bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400 mt-4 sm:mt-0">
                </div>
                <input type="email" name="email" placeholder="Adresse e-mail"
                    class="w-full p-3 border border-gray-700 rounded-xl mb-4 bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <input type="tel" name="phone" placeholder="Téléphone (optionnel)"
                    class="w-full p-3 border border-gray-700 rounded-xl mb-4 bg-gray-950 text-white focus:outline-none focus:ring-2 focus:ring-green-400">
                <button type="submit"
                    class="w-full bg-green-500 text-black font-semibold p-4 rounded-3xl hover:bg-green-600 transition text-lg shadow-lg">
                    Rejoindre le Mouvement
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
                        e.target.setCustomValidity('Format invalide. Utilisez : +1 (514) 123-1234');
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
                Votre&nbsp;Réseau. <br class="hidden sm:block"> Votre&nbsp;Force. <br class="hidden sm:block">
                Votre&nbsp;Opportunité.
            </h2>
            <p class="text-lg sm:text-2xl text-gray-300 max-w-lg mx-auto md:mx-0 mb-6 leading-relaxed">
                Peu importe où vous êtes, vous pouvez bâtir votre richesse. <br class="hidden sm:block">
                Connectez. Recommandez. Gagnez. C’est aussi simple que ça.
            </p>
            <p class="text-md sm:text-xl text-gray-400 max-w-lg mx-auto md:mx-0 mb-6">
                Nous accueillons des affiliés du monde entier — votre succès ne dépend pas de votre emplacement.
                📍🌎<br>
                Vos recommandations sont principalement liées à des clients de
                <span class="font-semibold">Montréal, Laval et les environs</span>.<br>
                Des frais peuvent s’appliquer en dehors de ces zones, mais votre commission reste inchangée.
            </p>
            <p class="text-md sm:text-xl text-gray-400 max-w-lg mx-auto md:mx-0">
                Soyez payé à votre façon : <span class="text-green-400 font-semibold">PayPal, Revolut, virement
                    Interac.</span><br class="hidden sm:block">
                Pas d’attente. Pas de tracas. Juste des gains réels, où que vous soyez.
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
                Gagnez Sans Limite. <br class="hidden sm:block" /> Grandissez à Chaque Connexion.
            </h1>
            <p class="text-lg sm:text-xl text-gray-300 max-w-xl">
                Chaque client que vous recommandez est une avancée — pour vous, pour eux, pour nous tous.
                Pas de plafond. Pas de limite. Juste du potentiel.
            </p>
            <div class="max-w-md sm:max-w-lg mx-auto">
                <ul class="space-y-4 text-white text-lg sm:text-xl font-medium">
                    <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">📦</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">120 $</span>
                                <span class="text-green-400 font-extrabold">Petit Déménagement</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(à Montréal / Laval)</span>
                    </li>
                    <li class="flex items-center justify-between border-b border-gray-700 pb-2">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">🏠</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">200 $</span>
                                <span class="text-green-400 font-extrabold">Déménagement Moyen</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(à Montréal / Laval)</span>
                    </li>
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-2xl text-gray-400">📍</span>
                            <span class="ml-3">
                                <span class="text-white font-semibold">250 $</span>
                                <span class="text-green-400 font-extrabold">Longue Distance</span>
                            </span>
                        </div>
                        <span class="text-gray-400 text-sm sm:text-base">(hors Montréal / Laval)</span>
                    </li>
                </ul>
            </div>

            <p class="text-md sm:text-lg text-gray-400 italic">
                QuickFix Brothers — Une communauté fondée sur la confiance, animée par la croissance, et portée par
                vous.
            </p>
        </div>



        <!-- iPhone Display Section -->
        <div class="mt-4 lg:w-1/2 flex justify-center">
            <div class="iphone-frame">
                <div class="iphone-notch"></div>
                <div class="balance-container">
                    <p class="balance-label">Solde actuel</p>
                    <div id="balance" class="balance">$0.00</div>
                </div>

                <div id="transactions" class="transactions"></div>

                <button class="cta-button">Encaisser!!!</button>
            </div>
        </div>
    </div>

    <section class="max-w-full mx-auto px-6 sm:px-12 py-12">
        <h2 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-center text-green-400 mb-6">
        Tes efforts. Ton Héritage.
        </h2>
        <p class="text-gray-400 text-center max-w-4xl mx-auto mb-12 text-lg sm:text-xl">
            Ce n’est pas juste un job de plus. C’est ta chance de construire une vraie richesse grâce à tes connexions.
            Chez QuickFix Brothers, on transforme les efforts en succès. Prêt à réclamer ta part ?
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
            <!-- Carte 1 - Travailles Quand Tu Veux -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">🚀</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Travailles Quand Tu Veux</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Pas d'horaires. Pas de pression.
                        Travaille <span class="text-green-400 font-semibold">à temps plein ou partiel</span>, à ton
                        rythme.
                        Étudiant, entrepreneur ou salarié, cette opportunité <span
                            class="text-green-400 font-semibold">s’adapte à toi</span>.
                    </p>
                </div>
            </div>

            <!-- Carte 2 - Revenus Illimités -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">💰</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Revenus Illimités</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Plus tu recommandes, plus tu gagnes.
                        <span class="text-green-400 font-semibold">Aucune limite.</span>
                        Que ce soit un revenu passif ou un vrai gagne-pain,
                        <span class="text-green-400 font-semibold">ton effort définit ton succès</span>.
                    </p>
                </div>
            </div>

            <!-- Carte 3 - Depuis N'importe Où -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">🌍</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Depuis N'importe Où</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Tes revenus ne dépendent plus d’un bureau.
                        Travaille depuis chez toi, un café ou même en voyage.
                        <span class="text-green-400 font-semibold">Cette opportunité te suit partout.</span>
                    </p>
                </div>
            </div>

            <!-- Carte 4 - Paiement Instantané -->
            <div
                class="bg-gray-900 border-2 border-green-400 rounded-xl p-6 sm:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <div class="text-green-400 text-4xl sm:text-5xl mb-4">⚡</div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-white">Paiement Instantané</h3>
                    <p class="text-gray-300 text-base sm:text-lg mt-4 leading-relaxed">
                        Sois payé <span class="text-green-400 font-semibold">sur-le-champ</span>.
                        Choisis <span class="text-green-400 font-semibold">PayPal, Revolut ou Virement Interac</span>.
                        Aucun délai. Aucun stress. <span class="text-green-400 font-semibold">Juste du vrai
                            revenu.</span>
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

    <script src="js/iphoneFr.js"></script>
    <script>
        document.getElementById("menu-btn").addEventListener("click", function () {
            document.getElementById("menu").classList.toggle("hidden");
        });
    </script>
</body>

</html>