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

    <a href="/user/profile">Voir mon profil</a><br>
<?php endif; ?>