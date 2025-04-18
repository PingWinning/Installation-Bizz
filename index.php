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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500;700&display=swap');

        .signature {
            font-family: 'Dancing Script', cursive;
            font-weight: 400;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

    <!-- Navbar with Language Toggle -->
    <nav class="bg-gray-800 p-5 flex flex-wrap md:flex-nowrap justify-between items-center">
        <div class="w-full md:w-auto text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-bold" id="main-title">Services Professionnels d'Installation</h1>
            <p class="text-gray-400 mt-2 text-sm md:text-base" id="subtitle">
                Votre partenaire de confiance pour une installation sans tracas
            </p>
        </div>
        
        <div class="flex flex-col md:flex-row items-center space-y-3 md:space-y-0 md:space-x-6 w-full md:w-auto mt-4 md:mt-0">
            <!-- Referral Program Link -->
            <div id="parrainage" class="w-full md:w-auto text-center">
                <a href="parrainage.php" class="font-bold text-white bg-green-700 hover:bg-green-400 px-6 py-2 text-sm md:text-base rounded-3xl font-medium transition-all block w-full md:w-auto">
                    <strong>Parrainez & Gagnez 200$</strong>
                </a>
            </div>

            <!-- Language Toggle -->
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
        </div>
    </nav>

    <section id="warning-fr" class="mt-3 p-4 md:p-6 bg-yellow-500 bg-opacity-30 text-white text-left md:text-center rounded-lg shadow-md border-2 border-yellow-500 max-w-[90%] mx-auto md:max-w-full">
    <h2 class="text-md md:text-lg font-bold mb-2 flex items-center justify-center gap-2">
        <i class="fas fa-shield-alt text-white"></i> Paiements sécurisés avec QuickFix Brothers <i class="fas fa-shield-alt text-white-600"></i>
    </h2>
    <p class="text-sm md:text-md leading-relaxed">
        Pour votre sécurité, <strong class="underline">tous les paiements sont effectués exclusivement via notre système officiel.</strong> 
        Nous ne collaborons avec aucun intermédiaire exigeant un paiement externe.
        <br><strong class="underline">Aucun affilié n'est autorisé à encaisser des paiements en notre nom.</strong>
        Si vous êtes sollicité pour un paiement externe, veuillez nous en informer immédiatement afin de prévenir toute fraude.
        <br>Si vous avez la moindre question, <strong>contactez-nous</strong> au  
        <a href="tel:+15145782382" class="underline no-break"><strong>+1&nbsp;(514)&nbsp;578-2382</strong></a>  
        ou par email à  
        <a href="mailto:InstallationServices@outlook.com" class="underline"><strong>InstallationServices@outlook.com</strong></a>.
    </p>
</section>

<section id="warning-en" class="mt-3 p-4 md:p-6 bg-yellow-500 bg-opacity-30 text-white text-left md:text-center rounded-lg shadow-md border-2 border-yellow-500 max-w-[90%] mx-auto md:max-w-full hidden">
    <h2 class="text-md md:text-lg font-bold mb-2 flex items-center justify-center gap-2">
        <i class="fas fa-shield-alt text-white"></i> Secure Payments with QuickFix Brothers <i class="fas fa-shield-alt text-white-600"></i>
    </h2>
    <p class="text-sm md:text-md leading-relaxed">
        For your security, <strong class="underline">all payments are processed exclusively through our official system.</strong>  
        We do not collaborate with any intermediaries requesting external payments.
        <br><strong class="underline">No affiliate is authorized to collect payments on our behalf.</strong>  
        If you are asked to make an external payment, please <strong class="underline">inform us immediately</strong> to help prevent fraud.
        If you have any questions, <strong>contact us</strong> at  
        <a href="tel:+15145782382" class="underline no-break"><strong>+1&nbsp;(514)&nbsp;578-2382</strong></a>  
        or by email at  
        <a href="mailto:InstallationServices@outlook.com" class="underline"><strong>InstallationServices@outlook.com</strong></a>.
    </p>
</section>

<style>
  .no-break {
      white-space: nowrap; /* Prevents breaking */
  }
</style>


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

        <!-- Business Metrics Section -->
        <div class="mt-16 p-8 min-h-[350px] flex flex-col items-center justify-center font-sans rounded-lg shadow-lg">
            <h2 class="text-yellow-500 text-5xl font-extrabold uppercase tracking-wide text-center mb-6">
                EXÉCUTION PARFAITE. PRÉCISION INÉGALÉE. EFFICACITÉ PROUVÉE.
            </h2>
            <p class="text-gray-300 text-lg text-center max-w-3xl mb-12">
                Nous avons appris là où la <em>vitesse</em> et la <em>précision</em> ne sont pas des choix,  
                mais des nécessités.  
                <strong class="text-yellow-400">Des milliers de commandes traitées, des centaines d’installations réalisées.</strong>  

                Dans les coulisses des entrepôts, nous avons monté, démonté, préparé et déplacé  
                des électroménagers, des meubles, des équipements lourds. 
                Chaque laveuse, chaque frigo, chaque canapé était une mission d’<em>efficacité absolue</em>.  

                <strong class="text-yellow-400">Nous avons perfectionné notre rigueur, notre rapidité et notre souci du détail</strong>  
                pour répondre aux exigences d’un environnement où <em>chaque seconde compte</em>.  

                Aujourd’hui, cette discipline devient <strong class="text-yellow-400">la clé du succès de vos projets</strong>.  
                Nous ne livrons pas qu’un service,<strong class="text-yellow-400"> nous livrons une expertise forgée par l’expérience.</strong>
            </p>


            <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-6 max-lg:gap-12">
                
                <!-- Commandes Livrées -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="1872" data-final="1.8"></span><span class="text-yellow-500">K</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Commandes Livrées</p>
                    <p class="text-sm text-gray-400 mt-2">Chaque commande traitée avec efficacité et soin.</p>
                </div>

                <!-- Projets Accomplis -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="1872" data-final="1.8"></span><span class="text-yellow-500">K</span>+
                    </h3>
                    <p class="text-base font-bold mt-4">Projets Accomplis</p>
                    <p class="text-sm text-gray-400 mt-2">Montages et assemblages réalisés avec rigueur.</p>
                </div>

                <!-- Taux de Satisfaction -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="95"></span><span class="text-yellow-500">%</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Taux de Satisfaction</p>
                    <p class="text-sm text-gray-400 mt-2">Nos clients apprécient notre professionnalisme.</p>
                </div>

                <!-- Intervention Rapide -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="24"></span><span class="text-yellow-500">H</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Intervention Rapide</p>
                    <p class="text-sm text-gray-400 mt-2">Nous intervenons en moins de 24 heures.</p>
                </div>

            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const counters = document.querySelectorAll(".counter");
                
                const animateCounter = (counter) => {
                    const target = +counter.getAttribute("data-target");
                    const finalText = counter.getAttribute("data-final"); // Récupère "1.8" pour affichage final si présent
                    let count = 0;
                    const increment = Math.ceil(target / 100);
                    
                    const updateCounter = () => {
                        if (count < target) {
                            count += increment;
                            if (count > target) count = target;
                            counter.innerText = count;
                            setTimeout(updateCounter, 30);
                        } else {
                            // Vérifie si une valeur finale spécifique est définie (ex : "1.8" pour 1800)
                            if (finalText) {
                                counter.innerText = finalText;
                            } else {
                                counter.innerText = target;
                            }
                        }
                    };

                    updateCounter();
                };

                const startCounters = () => {
                    counters.forEach(counter => animateCounter(counter));
                };

                // Démarrer l'animation lorsque la section est visible à l'écran
                const observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            startCounters();
                            observer.disconnect(); // Arrête d'observer après la première activation
                        }
                    });
                }, { threshold: 0.5 });

                observer.observe(document.querySelector(".counter").parentElement);
            });
        </script>

        <!-- Why Us Section -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-yellow-500 text-gray-900 p-8 border-l-4 border-r-4 border-gray-800 rounded-lg">
                <h2 class="text-3xl font-bold text-center mb-6">Notre Histoire, Votre Confiance</h2>
                <div class="max-w-3xl mx-auto text-lg leading-relaxed">
                    <p class="text-gray-900 mb-6">
                        <strong>Chers clients,</strong>
                    </p>

                    <p class="text-gray-900 mb-6">
                        Chez <strong>QuickFix Brothers</strong>, chaque projet est bien plus qu’une simple installation.  
                        C’est un engagement envers la <strong>qualité</strong>, l’<strong>expertise</strong> et votre satisfaction.  
                        Nous mettons notre <strong>rapidité</strong>, notre <strong>précision</strong> et notre <strong>professionnalisme</strong>  
                        au service de vos besoins.
                    </p>

                    <p class="text-gray-900 mb-6">
                        <strong>Chaque vis serrée, chaque meuble monté</strong>  
                        est le reflet de notre exigence et de la confiance que vous nous accordez.  
                        Nous savons que votre temps est précieux, et c’est pourquoi nous  
                        garantissons un service efficace et rigoureux.
                    </p>

                    <p class="text-gray-900 font-semibold">
                        Merci de faire confiance à QuickFix Brothers.
                    </p>

                    <!-- Signature manuscrite -->
                    <p class="signature text-gray-900 text-right text-2xl mt-8 pr-2">
                        L’équipe QuickFix Brothers
                    </p>
                </div>
            </div>
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

       <!-- Business Metrics Section -->
        <div class="mt-16 p-8 min-h-[350px] flex flex-col items-center justify-center font-sans rounded-lg shadow-lg">
            <h2 class="text-yellow-500 text-5xl font-extrabold uppercase tracking-wide text-center mb-6">
                FLAWLESS EXECUTION. UNMATCHED PRECISION. PROVEN EFFICIENCY.
            </h2>
            <p class="text-gray-300 text-lg text-center max-w-3xl mb-12">
                We mastered our craft in an environment where <em>speed</em> and <em>precision</em>  
                are not just choices—they are absolute necessities.  
                <strong class="text-yellow-400">Thousands of orders processed, hundreds of installations completed.</strong>  

                Behind the scenes in warehouses, we assembled, disassembled, prepared,  
                and moved appliances, furniture, and heavy equipment.  
                Every washer, every refrigerator, every sectional sofa was handled with  
                <em>absolute efficiency</em>.  

                <strong class="text-yellow-400">We have refined our discipline, speed, and attention to detail</strong>  
                to meet the demands of an environment where <em>every second counts</em>.  

                Today, this discipline is <strong class="text-yellow-400">the key to your project’s success</strong>.  
                We don’t just deliver a service—<strong class="text-yellow-400">we provide expertise forged through experience.</strong>
            </p>

            <div class="grid lg:grid-cols-4 sm:grid-cols-2 gap-6 max-lg:gap-12">
                
                <!-- Orders Delivered -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="1872" data-final="1.8"></span><span class="text-yellow-500">K</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Orders Delivered</p>
                    <p class="text-sm text-gray-400 mt-2">Every order handled with efficiency and care.</p>
                </div>

                <!-- Projects Completed -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="1872" data-final="1.8"></span><span class="text-yellow-500">K</span>+
                    </h3>
                    <p class="text-base font-bold mt-4">Projects Completed</p>
                    <p class="text-sm text-gray-400 mt-2">Assemblies and installations completed with precision.</p>
                </div>

                <!-- Customer Satisfaction -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="95"></span><span class="text-yellow-500">%</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Customer Satisfaction</p>
                    <p class="text-sm text-gray-400 mt-2">Our clients value our professionalism.</p>
                </div>

                <!-- Quick Response -->
                <div class="text-center">
                    <h3 class="text-white text-4xl font-extrabold">
                        <span class="counter" data-target="24"></span><span class="text-yellow-500">H</span>
                    </h3>
                    <p class="text-base font-bold mt-4">Fast Response</p>
                    <p class="text-sm text-gray-400 mt-2">We respond in less than 24 hours.</p>
                </div>

            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll(".counter");
            let hasAnimated = false; // Prevent multiple executions

            const animateCounter = (counter) => {
                const target = +counter.getAttribute("data-target");
                const finalText = counter.getAttribute("data-final"); // Gets "1.8" for final display if present
                let count = 0;
                const increment = Math.ceil(target / 100);

                const updateCounter = () => {
                    if (count < target) {
                        count += increment;
                        if (count > target) count = target;
                        counter.innerText = count;
                        setTimeout(updateCounter, 20);
                    } else {
                        if (finalText) {
                            counter.innerText = finalText;
                        } else {
                            counter.innerText = target;
                        }
                    }
                };

                updateCounter();
            };

            const startCounters = () => {
                if (!hasAnimated) {
                    counters.forEach(counter => animateCounter(counter));
                    hasAnimated = true;
                }
            };

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        startCounters();
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.8 });

            counters.forEach(counter => observer.observe(counter.parentElement));
        });
        </script>

        <!-- Why Us Section -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-yellow-500 text-gray-900 p-8 border-l-4 border-r-4 border-gray-800 rounded-lg">
                <h2 class="text-3xl font-bold text-center mb-6">Our Story, Your Trust</h2>
                <div class="max-w-3xl mx-auto text-lg leading-relaxed">
                    <p class="text-gray-900 mb-6">
                        <strong>Dear Customers,</strong>
                    </p>

                    <p class="text-gray-900 mb-6">
                        At <strong>QuickFix Brothers</strong>, every project is more than just an installation.  
                        It’s a commitment to <strong>quality</strong>, <strong>expertise</strong>, and your satisfaction.  
                        We bring our <strong>speed</strong>, <strong>precision</strong>, and <strong>professionalism</strong>  
                        to meet your needs.
                    </p>

                    <p class="text-gray-900 mb-6">
                        <strong>Every screw tightened, every piece of furniture assembled</strong>  
                        is a reflection of our high standards and the trust you place in us.  
                        We understand that your time is valuable, which is why we  
                        guarantee an efficient and meticulous service.
                    </p>

                    <p class="text-gray-900 font-semibold">
                        Thank you for trusting QuickFix Brothers.
                    </p>

                    <!-- Handwritten-style signature -->
                    <p class="signature text-gray-900 text-right text-2xl mt-8 pr-2">
                        The QuickFix Brothers Team
                    </p>
                </div>
            </div>
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
