<h1>Tableau de bord de l'utilisateur</h1>

<?php if (isset($_SESSION['user_nickname'])): ?>
    <h1>Bienvenue, <?= htmlspecialchars($_SESSION['user_nickname']) ?></h1>
    <p>Rôle(s) :
        <?php
        $userRoles = $_SESSION['user_roles'] ?? [];
        $labels = [];
        foreach ($userRoles as $roleId) {
            if (isset($roleLabels[$roleId])) {
                $labels[] = $roleLabels[$roleId];
            }
        }
        echo htmlspecialchars(implode(', ', $labels)).".";
        ?>
    </p>
    <?php

    $isPassenger = in_array(2, $userRoles, true);
    $isDriver = in_array(3, $userRoles, true);

    if ($isPassenger && $isDriver) {
        echo '<p>Vous êtes à la fois passager et conducteur. Vous pouvez accéder à votre profil et gérer votre voiture.</p>';
        echo '<a href="/user/profile">Voir mon profil</a><br>';
        echo '<a href="/user/car">Gérer ma voiture</a><br>';
    } elseif ($isPassenger) {
        echo '<p>Vous êtes un passager. Vous pouvez accéder à votre profil.</p>';
        echo '<a href="/user/profile">Voir mon profil</a><br>';
    } elseif ($isDriver) {
        echo '<p>Vous êtes un conducteur. Vous pouvez éditer votre profil et votre voiture.</p>';
        echo '<a href="/user/profile">Éditer mon profil</a><br>';
        echo '<a href="/user/car">Gérer ma voiture</a><br>';
    }
    ?>
    <?php else: ?>
        <p>Vous n'êtes pas connecté. Veuillez vous connecter pour accéder à votre tableau de bord.</p>
<?php endif; ?>