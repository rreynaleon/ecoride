<?php

namespace App\Routing;

class Router
{
    // Cette classe gère le routage des requêtes HTTP vers les contrôleurs appropriés
    private $routes;

    // Le constructeur charge le fichier de configuration des routes
    public function __construct()
    {
        $this->routes = require APP_ROOT . "/config/routes.php";
    }

    // Cette méthode gère la requête entrante et appelle le contrôleur approprié et son action
    public function handleRequest(string $uri): void
    {
        $path = self::normalizedPath($uri);

        // On vérifie si la route existe dans le fichier de configuration routes.php
        // routes.php est un tableau associatif où les clés sont les chemins et les valeurs sont des tableaux contenant le nom du contrôleur et de l'action
        if(isset($this->routes[$path])) {
            $route = $this->routes[$path];
            $controllerName = $route['controller'];
            $actionName = $route['action'];

            // On instancie le contrôleur et on appelle l'action
            $controller = new $controllerName();

            if(method_exists($controller, $actionName)){
                $controller->$actionName();
            }
        } else {
            // Si la route n'existe pas, on redirige vers la page d'erreur 404
            $errorController = new \App\Controller\ErrorController();
            $errorController->error404();
        }

    }

    // Cette méthode normalise le chemin de l'URI en supprimant les paramètres de requête et en gérant les slashs finaux
    public static function normalizedPath(string $uri): string
    {
        // On extrait que le chemin de l'URI sans les paramètres de requête
        // Par exemple, pour l'URI "/user/profile?id=5", on obtient "/user/profile"
        $path = parse_url($uri, PHP_URL_PATH);

        // On supprime les slashs finaux pour éviter les doublons et on ajoute un slash final pour normaliser le chemin
        // Par exemple, "/user/profile/" et "/user/profile" deviennent tous deux "/user/profile/"
        $path = rtrim($path, '/').'/';
        return $path;

    }

    // URI : désigne la partie de la requête qui identifie la ressource (ex : /user/profile?id=5)
    // URL : est une URI qui inclut également le protocole et le nom de domaine (ex : https://www.example.com/user/profile?id=5)

}