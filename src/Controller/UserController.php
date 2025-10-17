<?php

namespace App\Controller;

class UserController extends Controller
{
    public function dashboard()
    {
        // Logique pour afficher le tableau de bord de l'utilisateur
        $this->render('user/dashboard', [
            'roleLabels' => $this->roleLabels
    ]);
    }

    public function profile()
    {
        // Logique pour afficher le profil de l'utilisateur
        $this->render('user/profile', [
            'roleLabels' => $this->roleLabels
        ]);
    }

    public function edit()
    {
        // Logique pour éditer le profil de l'utilisateur
        $this->render('user/edit', [
            'roleLabels' => $this->roleLabels
        ]);
    }



}