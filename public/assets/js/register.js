console.log("Register.js chargé");

document.getElementById('registerForm').addEventListener('submit', function(e) {
        let errors = [];
        const form = e.target;

        // Prénom et nom
        if (form.name.value.trim().length < 2) errors.push("Le prénom doit faire au moins 2 caractères.");
        if (form.lastname.value.trim().length < 2) errors.push("Le nom doit faire au moins 2 caractères.");

        // Pseudo
        if (form.nickname.value.trim().length < 3) errors.push("Le pseudo doit faire au moins 3 caractères.");

        // Email
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(form.email.value)) errors.push("Email invalide.");

        // Mot de passe
        if (form.password.value.length < 8) errors.push("Le mot de passe doit faire au moins 8 caractères.");

        // Téléphone (optionnel)
        if (form.phone.value && !/^0[1-9][0-9]{8}$/.test(form.phone.value)) {
            errors.push("Téléphone invalide (format français attendu).");
        }

        // Date de naissance (optionnel)
        if (form.birthdate.value) {
            const birth = new Date(form.birthdate.value);
            const now = new Date();
            if (birth > now) errors.push("La date de naissance ne peut pas être dans le futur.");
        }

        // Rôles
        const roles = form.querySelectorAll('input[name="roles[]"]:checked');
        if (roles.length === 0) errors.push("Veuillez sélectionner au moins un rôle.");

        // Photo de profil (optionnel)
        if (form.profileImage.files.length > 0) {
            const file = form.profileImage.files[0];
            if (!file.type.startsWith('image/')) errors.push("Le fichier de profil doit être une image.");
            if (file.size > 2 * 1024 * 1024) errors.push("La photo de profil ne doit pas dépasser 2 Mo.");
        }

        // Affichage des erreurs
        if (errors.length > 0) {
            e.preventDefault();
            document.getElementById('formErrors').innerHTML = "<ul>" + errors.map(e => `<li>${e}</li>`).join('') + "</ul>";
        }
    });