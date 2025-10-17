<?php

namespace App\Controller;

class PageController extends Controller
{
    // La méthode est très importante car elle affiche la view principale de l'app et elle passe les labels des rôles à la vue home.php
    public function home()
    {
        $this->render("home", [
            'roleLabels' => $this->roleLabels
        ]);
    }
}