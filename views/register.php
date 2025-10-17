<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRide - Inscription</title>
</head>

<body>
    <h1>Inscription</h1>
    <form id="registerForm" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
        <label>Prénom : <input type="text" name="name" required maxlength="50"></label><br>
        <label>Nom : <input type="text" name="lastname" required maxlength="50"></label><br>
        <label>Pseudo : <input type="text" name="nickname" required maxlength="30"></label><br>
        <label>Email : <input type="email" name="email" required maxlength="100"></label><br>
        <label>Mot de passe : <input type="password" name="password" required minlength="8"></label><br>
        <label>Téléphone : <input type="tel" name="phone" pattern="^0[1-9][0-9]{8}$" maxlength="15"></label><br>
        <label>Adresse : <input type="text" name="address" maxlength="255"></label><br>
        <label>Date de naissance : <input type="date" name="birthdate"></label><br>
        <label>Photo de profil : <input type="file" name="profileImage" accept="image/*"></label><br>
        <fieldset>
            <legend>Rôle(s) souhaité(s)</legend>
            <input type="checkbox" name="roles[]" value="2" id="role_passenger">
            <label for="role_passenger">Passager</label>
            <input type="checkbox" name="roles[]" value="3" id="role_driver">
            <label for="role_driver">Conducteur</label>
        </fieldset>
        <button type="submit">S’inscrire</button>
    </form>
    <div id="formErrors" style="color:red;"></div>

    <script src="/assets/js/register.js"></script>
</body>

</html>