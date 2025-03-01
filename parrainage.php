<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
include('includes/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['last_submit']) || time() - $_SESSION['last_submit'] > 10) {
        $_SESSION['last_submit'] = time();
    } else {
        $_SESSION['error'] = "Veuillez attendre quelques secondes avant de soumettre à nouveau.";
        header("Location: parrainage.php");
        exit();
    }

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "L'adresse e-mail fournie est invalide. Veuillez entrer une adresse correcte.";
    } else {
        $submission_date = date("Y-m-d");
        $status = 'pending';

        $check_stmt = $conn->prepare("SELECT email FROM affiliates WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $_SESSION['error'] = "Cette adresse e-mail est déjà enregistrée dans notre système.";
        } else {
            $stmt = $conn->prepare("INSERT INTO affiliates (email, submission_date, status) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $submission_date, $status);

            if ($stmt->execute()) {
                $_SESSION['success'] = "Félicitations ! Votre inscription a été enregistrée avec succès. Vous recevrez toutes les informations nécessaires dans un délai de 2 à 5 jours ouvrables pour commencer à générer des revenus avec nous en tant qu'affilié. Merci de votre confiance !";
            } else {
                $_SESSION['error'] = "Une erreur s'est produite lors de l'inscription. Veuillez réessayer plus tard.";
                error_log("MySQL Error: " . $stmt->error);
            }
            $stmt->close();
        }

        $check_stmt->close();
        $conn->close();
    }

    header("Location: parrainage.php");
    exit();
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
<body class="bg-gray-800 text-gray-100">
    <header class="bg-gray-900 p-5">
        <nav class="flex items-center justify-between">
            <div class="flex-grow text-center">
                <h1 class="text-4xl font-bold text-white">
                    Programme de Parrainage
                </h1>
                <p class="mt-2 text-lg text-gray-300">
                    Gagnez 10% de commission en recommandant nos services !
                </p>
            </div>
            <button onclick="window.location.href='index.php'" class="bg-gray-700 text-white text-sm px-4 py-2 rounded hover:bg-gray-600">
                Accueil
            </button>
        </nav>
    </header>
    
    <main class="p-8">
        <section id="details" class="mb-12">
            <div class="mx-auto max-w-screen-md text-center mb-12 lg:mb-16">
                <h2 class="mb-6 text-5xl font-extrabold text-green-400">
                    Invitez, Partagez, Gagnez!
                </h2>
                <p class="text-lg font-light text-gray-400 sm:text-xl leading-relaxed">
                    Embarquez dans l'aventure de notre programme d'affiliation et transformez vos recommandations en véritables gains !  
                    Avec <span class="text-green-400 font-semibold">QuickFix Brothers</span>, découvrez l'alliance innovante du 
                    <span class="text-green-400 font-semibold">déménagement</span> et des 
                    <span class="text-green-400 font-semibold">services handyman</span> pour une solution clé en main qui révolutionne votre quotidien.
                </p>                       
            </div>

            <section class="p-4 bg-yellow-500 bg-opacity-30 text-white-900 text-center rounded-lg shadow-md border-2 border-yellow-500">
                <h2 class="text-lg font-bold mb-2"><i class="fas fa-shield-alt text-white-600"></i> Paiements sécurisés avec QuickFix Brothers <i class="fas fa-shield-alt text-white-600"></i></h2>
                <p class="text-md">
                    Pour votre sécurité, <strong class="underline">tous les paiements sont effectués exclusivement via notre système officiel.</strong> 
                    Nous ne collaborons avec aucun intermédiaire exigeant un paiement externe.<br><strong class="underline">Aucun affilié n'est autorisé à encaisser des paiements en notre nom.</strong>
                    Si vous êtes sollicité pour un paiement externe, veuillez nous en informer immédiatement afin de prévenir toute fraude.
                    <br>Si vous avez la moindre question, <strong>contactez-nous</strong> au 
                    <a href="tel:+15145782382" class="underline"><strong>+1 (514) 578-2382</strong></a> 
                    ou par email à 
                    <a href="mailto:InstallationServices@outlook.com" class="underline"><strong>InstallationServices@outlook.com</strong></a>.
                </p>
            </section><br>
    
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card: Petit Déménagement -->
                <div class="bg-gray-900 p-8 rounded-3xl shadow-lg text-center border border-gray-700 transform transition-transform duration-300 hover:scale-105">
                    <i class="fas fa-truck-moving text-6xl text-green-400 mb-4"></i>
                    <h3 class="mb-4 text-2xl font-semibold">Petit Déménagement</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Idéal pour les appartements ou petits logements.</p>
                    <div class="flex justify-center items-baseline my-8">
                        <span class="mr-2 text-5xl font-extrabold">$1200</span>
                        <span class="text-gray-500 dark:text-gray-400"><del>$1700</del></span>
                    </div>
    
                    <!-- Read More Section -->
                    <ul class="text-lg text-gray-400 mb-6 space-y-2 text-left max-h-40 overflow-hidden md:max-h-full transition-all duration-300 ease-in-out" id="details-1">
                        <li>✅ Planification détaillée</li>
                        <li>✅ Transport sécurisé (Montréal/Laval)</li>
                        <li>✅ Transport professionnel</li>
                        <li>✅ Protection complète des meubles (plastiques, rembourrages)</li>
                        <li>✅ Protection meubles, sofas, matelas (plastiques, sacs spécialisés)</li>
                        <li>✅ Emballage des objets fragiles (papier bulle, cartons)</li>
                        <li>✅ Sangles et fixation sécurisée dans le camion</li>
                        <li>❌ <strong>Service limité aux petits volumes</strong> : Convient aux studios, chambres, bureaux et déménagements légers.</li>
                        <li>❌ <strong>Frais supplémentaires pour zones éloignées</strong> : Tarification selon la distance.</li>
                        <li>❌ <strong>Essence non incluse</strong> : Facturation séparée selon le nombre de kilomètres parcourus.</li>
                        <li>❌ <strong>Frais de recyclage et d’emballage</strong> : Les frais de recyclage et d’emballage sont payables séparément après le service.</li>
                        <li>✅ <strong>Services complémentaires</strong> : Assemblage de meubles, installation de sofa-sectionnel, installation d’électroménagers, réparations domestiques sur demande. 
                            <a style="color: #1e90ff;  text-decoration: underline; font-weight: bold;" href="index.php" target="_blank">En savoir plus.</a>
                        </li>  
                    </ul>
    
                    <!-- Toggle Button for Small Screens -->
                    <button class="text-green-400 font-semibold mt-2 focus:outline-none md:hidden" onclick="toggleDetails('details-1', this)">Lire plus</button>
    
                    <!-- Commission (Always Visible) -->
                    <p class="mr-2 text-4xl font-extrabold text-green-500 mt-4">Commission : 120$</p>
                </div>
    
                <!-- Card: Gros Déménagement -->
                <div class="bg-gray-900 p-8 rounded-3xl shadow-lg text-center border border-gray-700 transform transition-transform duration-300 hover:scale-105">
                    <i class="fas fa-truck text-6xl text-green-400 mb-4"></i>
                    <h3 class="mb-4 text-2xl font-semibold">Gros Déménagement</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Parfait pour les grandes maisons ou gros volumes.</p>
                    <div class="flex justify-center items-baseline my-8">
                        <span class="mr-2 text-5xl font-extrabold">$2000</span>
                        <span class="text-gray-500 dark:text-gray-400"><del>$2500</del></span>
                    </div>
    
                    <ul class="text-lg text-gray-400 mb-6 space-y-2 text-left max-h-40 overflow-hidden md:max-h-full transition-all duration-300 ease-in-out" id="details-2">
                        <li>✅ Planification détaillée</li>
                        <li>✅ Transport sécurisé (Montréal/Laval)</li>
                        <li>✅ Transport professionnel</li>
                        <li>✅ Protection complète des meubles (plastiques, rembourrages)</li>
                        <li>✅ Protection meubles, sofas, matelas (plastiques, sacs spécialisés)</li>
                        <li>✅ Emballage des objets fragiles (papier bulle, cartons)</li>
                        <li>✅ Sangles et fixation sécurisée dans le camion</li>
                        <li>✅ <strong>Service disponible pour les grands volumes</strong> : Convient aux grandes maisons, appartements et bureaux.</li>
                        <li>❌ <strong>Frais supplémentaires pour zones éloignées</strong> : Tarification selon la distance.</li>
                        <li>❌ <strong>Essence non incluse</strong> : Facturation séparée selon le nombre de kilomètres parcourus.</li>
                        <li>❌ <strong>Frais de recyclage et d’emballage</strong> : Les frais de recyclage et d’emballage sont payables séparément après le service.</li>
                        <li>✅ <strong>Services complémentaires</strong> : Assemblage de meubles, installation de sofa-sectionnel, installation d’électroménagers, réparations domestiques sur demande. 
                            <a style="color: #1e90ff;  text-decoration: underline; font-weight: bold;" href="index.php" target="_blank">En savoir plus.</a>
                        </li>  
                    </ul>
    
                    <button class="text-green-400 font-semibold mt-2 focus:outline-none md:hidden" onclick="toggleDetails('details-2', this)">Lire plus</button>
    
                    <p class="mr-2 text-4xl font-extrabold text-green-500 mt-4">Commission : 200$</p>
                </div>
    
                <!-- Card: Déménagement Hors Montréal/Laval -->
                <div class="bg-gray-900 p-8 rounded-3xl shadow-lg text-center border border-gray-700 transform transition-transform duration-300 hover:scale-105">
                    <i class="fas fa-truck-loading text-6xl text-green-400 mb-4"></i>
                    <h3 class="mb-4 text-2xl font-semibold">Hors Montréal/Laval</h3>
                    <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Inclut les déménagements longue distance.</p>
                    <div class="flex justify-center items-baseline my-8">
                        <span class="mr-2 text-5xl font-extrabold">$2800</span>
                        <span class="text-gray-500 dark:text-gray-400"><del>$3300</del></span>
                    </div>
    
                    <ul class="text-lg text-gray-400 mb-6 space-y-2 text-left max-h-40 overflow-hidden md:max-h-full transition-all duration-300 ease-in-out" id="details-3">
                        <li>✅ Planification détaillée</li>
                        <li>✅ <strong>Transport sécurisé (longue distance)</strong> : Idéal pour les déménagements hors de Montréal et Laval.</li>
                        <li>✅ <strong>Transport professionnel (Longueuil, Brossard, Québec, Trois-Rivières et autres)</strong> : Véhicules adaptés et équipe expérimentée.</li>
                        <li>✅ Protection complète des meubles (plastiques, rembourrages)</li>
                        <li>✅ Protection meubles, sofas, matelas (plastiques, sacs spécialisés)</li>
                        <li>✅ Emballage des objets fragiles (papier bulle, cartons)</li>
                        <li>✅ Sangles et fixation sécurisée dans le camion</li>
                        <li>✅ <strong>Service disponible pour les grands et petits volumes</strong> : Convient aux maisons, appartements et bureaux.</li>
                        <li>❌ <strong>Essence non incluse</strong> : Facturation séparée selon le nombre de kilomètres parcourus.</li>
                        <li>❌ <strong>Frais de recyclage et d’emballage</strong> : Les frais de recyclage et d’emballage sont payables séparément après le service.</li>
                        <li>✅ <strong>Services complémentaires</strong> : Assemblage de meubles, installation de sofa-sectionnel, installation d’électroménagers, réparations domestiques sur demande. 
                            <a style="color: #1e90ff;  text-decoration: underline; font-weight: bold;" href="index.php" target="_blank">En savoir plus.</a>
                        </li>  
                    </ul>
                    
                    <button class="text-green-400 font-semibold mt-2 focus:outline-none md:hidden" onclick="toggleDetails('details-3', this)">Lire plus</button>
                    
                    <p class="mr-2 text-4xl font-extrabold text-green-500 mt-4">Commission : 250$</p>
                </div>
            </div>
        </section>
    </main>
    
    <script>
        function toggleDetails(id, btn) {
            let details = document.getElementById(id);
            if (details.classList.contains('max-h-40')) {
                details.classList.remove('max-h-40');
                details.classList.add('max-h-full');
                btn.innerText = "Lire moins";
            } else {
                details.classList.add('max-h-40');
                details.classList.remove('max-h-full');
                btn.innerText = "Lire plus";
            }
        }
    </script>      

    <section id="affiliate-program" class="mb-8">
    <div class="bg-gray-900 p-10 rounded-lg shadow-lg text-center border border-gray-700">
        <h2 class="text-4xl font-bold text-center mb-8 text-green-400">Devenez un Partenaire Affilié</h2>
        <p class="text-lg text-gray-300 text-left mx-auto max-w-3xl">
            Rejoignez notre programme d’affiliation et gagnez des commissions en recommandant nos services.
            <strong>QuickFix Brothers</strong> allie <span class="text-green-400 font-semibold">déménagement</span> et <span class="text-green-400 font-semibold">services handyman</span> pour une solution clé en main !
        </p>
        
        <!-- Avantages du programme -->
        <div class="bg-gray-800 p-6 mt-6 rounded-lg text-left mx-auto max-w-3xl border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-4">Pourquoi nous choisir ?</h3>
            <ul class="text-lg text-gray-300 space-y-3">
                <li>✅ <strong>Service tout-en-un :</strong> Nous combinons <span class="text-green-400 font-semibold">déménagement</span> et <span class="text-green-400 font-semibold">installation</span> pour une transition rapide et sans stress.</li>
                <li>✅ <strong>Commission attractive :</strong> Gagnez <span class="text-green-400 font-semibold">10% de commission</span> sur chaque contrat signé, calculé sur le <span class="text-green-400 font-semibold">forfait choisi par le client</span>.</li>
                <li>✅ <strong>Paiement rapide :</strong> Recevez vos commissions sous 7 jours via <span class="text-green-400 font-semibold">PayPal, virement bancaire ou eTransfer</span>.</li>
                <li>✅ <strong>Bonus fidélité :</strong> Un <span class="text-green-400 font-semibold">bonus de 100$</span> est offert après <span class="text-green-400 font-semibold">10 clients signés et confirmés</span>.</li>
                <li>✅ <strong>Travail à distance possible :</strong> Vous pouvez <span class="text-green-400 font-semibold">promouvoir nos services depuis n’importe où dans le monde</span> 🌍.</li>
                <li>❌ <strong>Clients acceptés uniquement à Montréal et Laval :</strong> Pour l’instant, nous acceptons uniquement les clients qui déménagent <span class="text-green-400 font-semibold">vers ou depuis Montréal/Laval</span>. Pour d’autres régions, des <span class="text-green-400 font-semibold">frais supplémentaires</span> peuvent s’appliquer.</li>
            </ul>
        </div>

        <!-- Formulaire d'inscription -->
        <div class="mt-10">
            <h3 class="text-2xl font-semibold text-white mb-4">Recevez le contrat et les instructions</h3>
            <form id="affiliate-form" class="flex flex-col justify-center items-center space-y-4 w-full max-w-md mx-auto" action="parrainage.php" method="POST">
                <input type="email" id="email" name="email" placeholder="Entrez votre email" 
                    class="w-full p-3 bg-gray-800 text-gray-200 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-green-400 transition duration-200 ease-in-out">
                <button type="submit" 
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 ease-in-out">
                    Devenir un Partenaire
                </button>
            </form>
            <p id="confirmation-message" class="text-green-400 mt-4 hidden">Merci ! Nous vous enverrons les détails sous peu.</p>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-gray-900 p-8 rounded-lg shadow-lg text-center border border-gray-700 max-w-md relative">
                <div id="modal-icon" class="text-6xl mb-4"></div>
                <p id="modal-message" class="text-white text-lg font-semibold"></p>
                <button onclick="closeModal()" class="mt-6 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">Fermer</button>
            </div>
        </div>

        <!-- FAQ Dynamique -->
        <div class="mt-12 bg-gray-800 p-6 rounded-lg text-left mx-auto max-w-3xl border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-4">Questions Fréquentes</h3>
        
            <!-- Paiement des commissions -->
            <details class="mb-4">
                <summary class="cursor-pointer text-green-400 font-semibold">
                    Comment fonctionne le paiement des commissions ?
                </summary>
                <div class="text-gray-300 mt-2">
                    <ol class="list-decimal ml-6">
                        <li class="mb-2">
                            <strong>Signature du contrat :</strong> Lorsque vous recommandez un client, il doit signer un contrat officiel mentionnant clairement votre identifiant unique. Cette référence est essentielle pour suivre et valider votre commission.
                        </li>
                        <li class="mb-2">
                            <strong>Vérification et validation :</strong> Une fois le contrat signé, vous devez nous l’envoyer par e-mail. Nous contactons ensuite le client pour confirmer les informations essentielles : 
                            <ul class="list-disc ml-6 mt-2">
                                <li>Type de service choisi (<span class="text-green-400 font-semibold">Petit Déménagement, Gros Déménagement, Hors Montréal/Laval</span>).</li>
                                <li>Adresse de départ et d’arrivée.</li>
                                <li>Date et conditions du déménagement.</li>
                            </ul>
                        </li>
                        <li class="mb-2">
                            <strong>Paiement de la commission :</strong> Une fois la prestation officiellement réservée, le client dispose d’un délai de 10 jours pour annuler et être remboursé. Une fois la prestation effectuée et payée en totalité par le client, nous vous versons votre commission via <span class="text-green-400 font-semibold">PayPal</span> ou <span class="text-green-400 font-semibold">virement e-transfer</span> sous 7 à 10 jours.
                        </li>
                    </ol>
                    <p class="mt-4">
                        <strong>Clause anti-fraude :</strong> <br>
                        Dès la première ligne du contrat signé par le client, il est stipulé en <span class="text-green-400 font-semibold">gras</span> que les paiements doivent être effectués exclusivement via notre système. <span class="text-red-400 font-semibold">Les agents affiliés sont strictement interdits de percevoir un paiement à notre place.</span>  
                        Tout non-respect de cette règle entraînera la nullité de la commission et pourra donner lieu à des poursuites pour fraude.
                    </p>
                </div>
            </details>
        
            <!-- Promotion en ligne -->
            <details class="mb-4">
                <summary class="cursor-pointer text-green-400 font-semibold">
                    Comment puis-je promouvoir vos services et obtenir des commissions ?
                </summary>
                <p class="text-gray-300 mt-2">
                    En tant qu'affilié, vous pouvez promouvoir <span class="text-green-400 font-semibold">nos services de déménagement ainsi que nos services de bricolage et installation</span> sur différentes plateformes numériques et auprès de votre réseau.  
                    <br><br>
                    📢 <strong>Utilisez les réseaux sociaux et le bouche-à-oreille pour maximiser vos gains !</strong>  
                    Voici quelques stratégies efficaces :
                </p>
                <ul class="list-disc ml-6 mt-2">
                    <li>🎬 <strong>Créer du contenu engageant :</strong> Vidéos explicatives, témoignages clients et démonstrations de service.</li>
                    <li>📲 <strong>Partager sur les plateformes populaires :</strong> TikTok, Facebook, Instagram, LinkedIn.</li>
                    <li>🔗 <strong>Utiliser votre lien de parrainage :</strong> Redirigez vos contacts vers notre site pour qu'ils puissent nous contacter facilement.</li>
                    <li>👥 <strong>Développer un réseau local :</strong> Recommandez nos services à vos amis, votre famille et vos collègues.</li>
                </ul>
                <p class="mt-4">
                    💡 <strong>Astuce :</strong> Un affilié performant ne vend pas seulement un service, il construit une relation de confiance avec ses prospects.  
                    Soyez <span class="text-green-400 font-semibold">créatif, authentique et persévérant</span> pour maximiser vos commissions !  
                </p>
            </details>            
        
            <!-- Commissions et gains -->
            <details class="mb-4" open>
                <summary class="cursor-pointer text-green-400 font-semibold">
                    Combien puis-je gagner grâce au parrainage ?
                </summary>
                <p class="text-gray-300 mt-2">
                    Le montant de votre commission dépend du type de service réservé par le client référé :  
                </p>
                <ul class="list-disc ml-6 mt-2">
                    <li><span class="text-green-400 font-semibold">Petit déménagement :</span> Commission de 120$.</li>
                    <li><span class="text-green-400 font-semibold">Déménagement standard :</span> Commission de 200$.</li>
                    <li><span class="text-green-400 font-semibold">Gros déménagement :</span> Commission de 250$.</li>
                </ul>
                <p class="mt-4">
                    💡 <strong>Exemple de gains mensuels :</strong>
                </p>
                <ul class="list-disc ml-6 mt-2">
                    <li>Si vous parrainez <span class="text-green-400 font-semibold">10 clients par mois</span>, vous pouvez gagner environ <span class="text-green-400 font-semibold">1,200.00$</span> (en supposant des petits déménagements).</li>
                    <li>Avec <span class="text-green-400 font-semibold">30 clients par mois</span>, vos revenus peuvent atteindre <span class="text-green-400 font-semibold">6,000.00$</span> (en supposant des services standards).</li>
                    <li>Si vous êtes un affilié très actif et référez <span class="text-green-400 font-semibold">50 clients par mois</span>, vous pourriez gagner jusqu’à <span class="text-green-400 font-semibold">12,500.00$</span> (avec de gros déménagements).</li>
                </ul>
                <p class="mt-4">
                    📈 <strong>Plus vous recommandez de clients, plus vos revenus augmentent. Il n’y a pas de limite de gains !</strong> 🚀
                </p>
            </details>            
        
            <!-- Partenariats d'affaires -->
            <details class="mb-4">
                <summary class="cursor-pointer text-green-400 font-semibold">
                    Proposez-vous des offres pour les entreprises et professionnels ?
                </summary>
                <p class="text-gray-300 mt-2">
                    Oui, nous collaborons avec des <span class="text-green-400 font-semibold">agences immobilières, magasins de meubles, vendeurs d’électroménagers</span> et autres acteurs du secteur.  
                    Nos partenaires bénéficient d’un <span class="text-green-400 font-semibold">programme d’affiliation exclusif</span> leur permettant de générer des revenus supplémentaires en recommandant nos services à leurs clients.
                </p>
                <p class="mt-4">
                    Si vous êtes une entreprise intéressée par un partenariat, contactez-nous pour discuter des modalités et des avantages de notre collaboration.
                </p>
            </details>
        
            <!-- Conditions générales -->
            <details>
                <summary class="cursor-pointer text-green-400 font-semibold">
                    Quelles sont les conditions pour recevoir ma commission ?
                </summary>
                <p class="text-gray-300 mt-2">
                    Pour être éligible au paiement de votre commission :
                </p>
                <ul class="list-disc ml-6 mt-2">
                    <li>Le déménagement doit être entièrement réalisé et réglé par le client.</li>
                    <li>Le contrat signé doit comporter votre identifiant unique.</li>
                    <li>Aucune tentative de fraude ou manipulation ne doit être détectée.</li>
                </ul>
                <p class="mt-4">
                    <span class="text-red-400 font-semibold">Attention :</span> Toute tentative de fraude, comme la perception d’un paiement direct par un affilié, l’utilisation d’informations falsifiées ou la manipulation des contrats, entraînera la suppression immédiate de votre commission et pourra donner lieu à des poursuites légales.
                </p>
            </details>
        </div>              
    </div>
</section>

    <script>
        function closeModal() {
            document.getElementById("modal").classList.add("hidden");
        }

        window.onload = function() {
            let modal = document.getElementById("modal");
            let modalMessage = document.getElementById("modal-message");
            let modalIcon = document.getElementById("modal-icon");
            
            <?php if (isset($_SESSION['success'])): ?>
                modalMessage.innerText = "<?php echo $_SESSION['success']; unset($_SESSION['success']); ?>";
                modalIcon.innerHTML = "<i class='fas fa-check-circle text-green-400'></i>";
                modal.classList.remove("hidden");
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                modalMessage.innerText = "<?php echo $_SESSION['error']; unset($_SESSION['error']); ?>";
                modalIcon.innerHTML = "<i class='fas fa-times-circle text-red-400'></i>";
                modal.classList.remove("hidden");
            <?php endif; ?>
        };

        document.querySelectorAll("details").forEach((detail) => {
            detail.addEventListener("click", function () {
                document.querySelectorAll("details").forEach((otherDetail) => {
                    if (otherDetail !== detail) {
                        otherDetail.removeAttribute("open");
                    }
                });
            });
        });
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


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
