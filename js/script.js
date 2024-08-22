document.getElementById('switch').addEventListener('change', function() {
    if (this.checked) {
        // Switch to English
        document.getElementById('main-title').textContent = "Professional Installation Services";
        document.getElementById('subtitle').textContent = "Your trusted partner for hassle-free setup and installation";
        document.getElementById('description-fr').classList.add('hidden');
        document.getElementById('description-en').classList.remove('hidden');
        document.getElementById('services-title').textContent = "Our Services";
        document.getElementById('contact-title').textContent = "Contact Us";
        
        // Update service titles and descriptions
        document.getElementById('service-1-title').textContent = "Furniture Assembly";
        document.getElementById('service-1-desc').textContent = "We expertly assemble all types of furniture, ensuring everything is secure and ready for use.";
        
        document.getElementById('service-2-title').textContent = "TV Installation";
        document.getElementById('service-2-desc').textContent = "Our team safely mounts your smart TV on any wall, optimizing your viewing experience.";
        
        document.getElementById('service-3-title').textContent = "Sofa Setup";
        document.getElementById('service-3-desc').textContent = "We connect and configure sectional sofas to perfectly fit your space and lifestyle.";
        
        document.getElementById('service-4-title').textContent = "Box Opening & Recycling";
        document.getElementById('service-4-desc').textContent = "We handle the tedious task of unboxing and recycling, leaving your space tidy and organized.";
        
        document.getElementById('service-5-title').textContent = "Appliance Installation";
        document.getElementById('service-5-desc').textContent = "We install your ovens, refrigerators, microwaves, and other appliances with precision and care.";
        
        document.getElementById('service-6-title').textContent = "Moving Services";
        document.getElementById('service-6-desc').textContent = "We provide professional moving services in Laval and Montreal. For longer distances, additional fees may apply.";
        
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
        document.getElementById('main-title').textContent = "Services Professionnels d'Installation";
        document.getElementById('subtitle').textContent = "Votre partenaire de confiance pour une installation sans tracas";
        document.getElementById('description-en').classList.add('hidden');
        document.getElementById('description-fr').classList.remove('hidden');
        document.getElementById('services-title').textContent = "Nos Services";
        document.getElementById('contact-title').textContent = "Contactez-Nous";
        
        // Update service titles and descriptions
        document.getElementById('service-1-title').textContent = "Assemblage de Meubles";
        document.getElementById('service-1-desc').textContent = "Nous assemblons avec expertise tous types de meubles, en veillant à ce que tout soit sécurisé et prêt à l'emploi.";
        
        document.getElementById('service-2-title').textContent = "Installation de Téléviseurs";
        document.getElementById('service-2-desc').textContent = "Notre équipe monte en toute sécurité votre téléviseur intelligent sur n'importe quel mur, optimisant ainsi votre expérience de visionnage.";
        
        document.getElementById('service-3-title').textContent = "Branchement de Canapés";
        document.getElementById('service-3-desc').textContent = "Nous connectons et configurons les canapés modulaires pour qu'ils s'adaptent parfaitement à votre espace et à votre style de vie.";
        
        document.getElementById('service-4-title').textContent = "Ouverture & Recyclage de Boîtes";
        document.getElementById('service-4-desc').textContent = "Nous nous occupons de la tâche fastidieuse du déballage et du recyclage, laissant votre espace propre et bien organisé.";
        
        document.getElementById('service-5-title').textContent = "Installations d'Électroménagers";
        document.getElementById('service-5-desc').textContent = "Nous installons vos fours, réfrigérateurs, micro-ondes, et autres appareils avec précision et soin.";
        
        document.getElementById('service-6-title').textContent = "Services de Déménagement";
        document.getElementById('service-6-desc').textContent = "Nous offrons des services de déménagement professionnels à Laval et Montréal. Pour des distances plus longues, des frais supplémentaires peuvent s'appliquer.";
        
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
