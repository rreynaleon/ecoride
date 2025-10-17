<?php

namespace App\Controller;

use Exception;
class Controller
{
    protected array $roleLabels = [
        1 => 'Administrateur',
        2 => 'Passager',
        3 => 'Conducteur'
    ];

    public function __construct()
    {
        // Démarrer la session si elle n'est pas déjà active
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function render(string $view, array $data = []): void
    {
        $viewPath = __DIR__ . "/../../views/$view.php";

        if (file_exists($viewPath)) {

            extract($data); // Extract permet de transformer les clés du tableau $data en variables
            // Par exemple, si $data = ['categories' => $categories], alors $categories sera une variable qui contiendra la valeur de $categories

            require_once $viewPath;

        } else {
            // Si le fichier de vue n'existe pas, on peut lancer une exception ou afficher une erreur
            throw new \Exception("View not found: $viewPath");
        }
    }



}