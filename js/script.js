document.getElementById('switch').addEventListener('change', function() {
    const frDescription = document.getElementById('description-fr');
    const enDescription = document.getElementById('description-en');

    if (this.checked) {
        // Switch to English
        frDescription.classList.add('hidden');
        enDescription.classList.remove('hidden');
        
        document.getElementById('main-title').textContent = "Professional Installation Services";
        document.getElementById('subtitle').textContent = "Your trusted partner for hassle-free setup and installation";
        document.getElementById('services-title').innerHTML = '<i class="fas fa-tools"></i>&nbsp;Our Services';
        document.getElementById('contact-title').textContent = "Contact Us";
        document.getElementById('termes').innerHTML = 'By clicking "Send," you agree to our <a href="terms-and-conditions.html" class="text-blue-500 hover:underline">terms and conditions</a>.';
        document.getElementById('parrainage').innerHTML = '<a href="parrainage.html" class="text-white bg-blue-500 hover:bg-blue-400 px-6 py-2 text-sm md:text-base rounded-md font-medium transition-all block w-full md:w-auto">Refer & Earn $200</a>';

        // Update service titles and descriptions with icons
        document.getElementById('service-1-title').innerHTML = '<i class="fas fa-couch"></i>&nbsp;Furniture/Patio Assembly';
        document.getElementById('service-1-desc').textContent = "Need help assembling new office furniture or an outdoor patio lounge for your new deck? Hire us to help you put together the pieces of your indoor and outdoor furniture.";
        
        document.getElementById('service-2-title').innerHTML = '<i class="fas fa-tv"></i>&nbsp;TV Installation';
        document.getElementById('service-2-desc').textContent = "Our team safely mounts your smart TV on any wall, optimizing your viewing experience. Create a modern and elegant space while enhancing your viewing comfort.";
        document.getElementById('service-indispo').textContent = "Service currently unavailable";

        document.getElementById('service-3-title').innerHTML = '<i class="fas fa-couch"></i>&nbsp;Sofa Setup';
        document.getElementById('service-3-desc').textContent = "We connect and configure modular sofas to perfectly fit your space. We can also advise you on the selection and arrangement of sofas and sectionals for a practical and elegant interior.";
        
        document.getElementById('service-4-title').innerHTML = '<i class="fas fa-recycle"></i>&nbsp;Box Opening & Recycling';
        document.getElementById('service-4-desc').textContent = "We handle the tedious task of unboxing and recycling, leaving your space tidy and well-organized. Caring for the environment is important to us, which is why we recycle all materials responsibly.";
        
        document.getElementById('service-5-title').innerHTML = '<i class="fas fa-blender"></i>&nbsp;Appliance Installation';
        document.getElementById('service-5-desc').textContent = "We install your ovens, refrigerators, microwaves, and other appliances with precision and care. We can also arrange the delivery of your appliances to your home, if needed.";
        
        document.getElementById('service-6-title').innerHTML = '<i class="fas fa-truck-moving"></i>&nbsp;Moving Services';
        document.getElementById('service-6-desc').textContent = "We provide professional moving services in Laval and Montreal. For longer distances, additional fees may apply.";

        document.getElementById('service-7-title').innerHTML = '<i class="fas fa-desktop"></i>&nbsp;Home Office Setup';
        document.getElementById('service-7-desc').textContent = "We assist clients in setting up home offices, including assembling desks, chairs, setting up computer equipment, and managing cables.";

        document.getElementById('service-8-title').innerHTML = '<i class="fas fa-wrench"></i>&nbsp;Domestic Repairs';
        document.getElementById('service-8-desc').textContent = "Need help with home repairs? Let us fix your doors, replace handles, or repair wall cracks and holes. Our expertise guarantees quick and precise work, restoring your home's beauty in no time.";

        document.getElementById('service-9-title').innerHTML = '<i class="fas fa-snowflake"></i>&nbsp;Driveway Snow Removal';
        document.getElementById('service-9-desc').textContent = "We offer driveway snow removal and garage entrance snow removal services during the winter.";

        // Update contact form fields
        document.querySelector("label[for='name']").textContent = "Name";
        document.getElementById('name').placeholder = "Your Name";
        
        document.querySelector("label[for='email']").textContent = "Email";
        document.getElementById('email').placeholder = "Your Email";
        
        document.querySelector("label[for='phone']").textContent = "Phone";
        document.getElementById('phone').placeholder = "Your Phone Number";
        
        document.querySelector("label[for='message']").textContent = "Message";
        document.getElementById('message').placeholder = "How can we assist you?";
        
        document.querySelector("button[type='submit']").textContent = "Send";

    } else {
        // Switch to French
        enDescription.classList.add('hidden');
        frDescription.classList.remove('hidden');

        document.getElementById('main-title').textContent = "Services Professionnels d'Installation";
        document.getElementById('subtitle').textContent = "Votre partenaire de confiance pour une installation sans tracas";
        document.getElementById('services-title').innerHTML = '<i class="fas fa-tools"></i>&nbsp;Nos Services';
        document.getElementById('contact-title').textContent = "Contactez-Nous";
        document.getElementById('termes').innerHTML = 'En cliquant sur "Envoyer", vous acceptez nos <a href="terms-et-conditions.html" class="text-blue-500 hover:underline">termes et conditions</a>.';
        document.getElementById('parrainage').innerHTML = '<a href="parrainage.html" class="text-white bg-blue-500 hover:bg-blue-400 px-6 py-2 text-sm md:text-base rounded-md font-medium transition-all block w-full md:w-auto">Parrainez & Gagnez 200$</a>';

        // Update service titles and descriptions with icons
        document.getElementById('service-1-title').innerHTML = '<i class="fas fa-couch"></i>&nbsp;Assemblage de Meubles/Patio';
        document.getElementById('service-1-desc').textContent = "Besoin d'aide pour assembler de nouveaux meubles de bureau ou un salon de patio extérieur pour votre nouvelle terrasse ? Engagez-nous pour vous aider à assembler les éléments de vos meubles d'intérieur et d'extérieur.";
        
        document.getElementById('service-2-title').innerHTML = '<i class="fas fa-tv"></i>&nbsp;Installation de Téléviseurs';
        document.getElementById('service-2-desc').textContent = "Notre équipe installe en toute sécurité votre téléviseur intelligent sur n'importe quel mur, optimisant ainsi votre expérience de visionnage. Offrez-vous un espace moderne et élégant pour une expérience visuelle améliorée.";
        document.getElementById('service-indispo').textContent = "Service actuellement indisponible";

        document.getElementById('service-3-title').innerHTML = '<i class="fas fa-couch"></i>&nbsp;Branchement de Canapés';
        document.getElementById('service-3-desc').textContent = "Nous connectons et configurons les canapés modulaires pour qu'ils s'intègrent parfaitement à votre espace. Nous pouvons également vous conseiller sur le choix et l'agencement des canapés et sectionnels, pour un intérieur à la fois pratique et élégant.";
        
        document.getElementById('service-4-title').innerHTML = '<i class="fas fa-recycle"></i>&nbsp;Ouverture & Recyclage de Boîtes';
        document.getElementById('service-4-desc').textContent = "Nous nous occupons de la tâche fastidieuse du déballage et du recyclage, laissant votre espace propre et bien organisé. Le respect de l'environnement nous tient à cœur, c'est pourquoi nous recyclons tous les matériaux de manière responsable.";
        
        document.getElementById('service-5-title').innerHTML = '<i class="fas fa-blender"></i>&nbsp;Installations d\'Électroménagers';
        document.getElementById('service-5-desc').textContent = "Nous installons vos fours, réfrigérateurs, micro-ondes et autres appareils avec précision et soin. Nous nous chargeons également de la livraison de vos électroménagers à domicile, si besoin.";
        
        document.getElementById('service-6-title').innerHTML = '<i class="fas fa-truck-moving"></i>&nbsp;Services de Déménagement';
        document.getElementById('service-6-desc').textContent = "Nous offrons des services de déménagement professionnels à Laval et Montréal. Pour des distances plus longues, des frais supplémentaires peuvent s'appliquer.";

        document.getElementById('service-7-title').innerHTML = '<i class="fas fa-desktop"></i>&nbsp;Configuration de Bureau à Domicile';
        document.getElementById('service-7-desc').textContent = "Nous assistons les clients dans la configuration de bureaux à domicile, y compris l'assemblage de bureaux, de chaises, la mise en place de l'équipement informatique et la gestion des câbles.";

        document.getElementById('service-8-title').innerHTML = '<i class="fas fa-wrench"></i>&nbsp;Réparations domestiques';
        document.getElementById('service-8-desc').textContent = "Besoin d'aide pour des réparations à la maison ? Confiez-nous la tâche de fixer vos portes, remplacer des poignées, ou encore réparer les fissures et trous dans vos murs. Notre expertise garantit un travail soigné et rapide, pour que votre maison retrouve tout son éclat en un rien de temps !";

        document.getElementById('service-9-title').innerHTML = '<i class="fas fa-snowflake"></i>&nbsp;Déneigement d\'Entrée';
        document.getElementById('service-9-desc').textContent = "Nous offrons des services de déneigement d'entrée et d'entrée de garage pendant l'hiver.";

        // Update contact form fields
        document.querySelector("label[for='name']").textContent = "Nom";
        document.getElementById('name').placeholder = "Votre Nom";
        
        document.querySelector("label[for='email']").textContent = "Email";
        document.getElementById('email').placeholder = "Votre Email";
        
        document.querySelector("label[for='phone']").textContent = "Téléphone";
        document.getElementById('phone').placeholder = "Votre Numéro de Téléphone";
        
        document.querySelector("label[for='message']").textContent = "Message";
        document.getElementById('message').placeholder = "Comment pouvons-nous vous aider ?";
        
        document.querySelector("button[type='submit']").textContent = "Envoyer";
    }
});