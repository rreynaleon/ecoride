<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoRide - Accueil</title>

</head>

<body>
    <header>
        <div>
            <?php if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in']) : ?>
                <p>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nickname']); ?> !</p>

                <p>Rôle(s) :
                    <?php
                    $userRoles = $_SESSION['user_roles'] ?? [];
                    $labels = [];
                    foreach ($userRoles as $roleId) {
                        if (isset($roleLabels[$roleId])) {
                            $labels[] = $roleLabels[$roleId];
                        }
                    }
                    echo htmlspecialchars(implode(', ', $labels));
                    ?>
                    <?php echo ".<br>"; ?>
                </p>

                <form action="/logout" method="post" style="display:inline;">
                    <button type="submit">Déconnexion</button>
                </form>

            <?php endif; ?>
        </div>



        <nav>
            <ul>
                <li><a href="/">Accueil</a></li>
                <li><a href="/login">Connexion</a></li>
                <li><a href="/register">Inscription</a></li>
                <li><a href="/logout">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Bienvenue sur EcoRide</h1>
        <p>Votre solution de mobilité écologique.</p>
        <button id="learn-more-btn">En savoir plus</button>
    </main>
    <footer>
        <p>&copy; 2024 EcoRide. Tous droits réservés.</p>
    </footer>
</body>

</html>