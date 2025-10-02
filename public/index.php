<?php

echo "Hello, EcoRide !". "<br>";
echo "La connection à la base de données a réussi !";

// Inclus le fichier d'autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Constantes de configuration de l'application

// On définit une constante avec le chemin de base de l'application parce que l'on va l'utiliser dans plusieurs fichiers pour inclure des fichiers
// la méthode dirname(__DIR__) permet de remonter d'un niveau dans l'arborescence des dossiers
define('APP_ROOT', dirname(__DIR__));
// Par exemple si le fichier index.php est dans le dossier public, dirname(__DIR__) renvoie le chemin du dossier parent, qui est le dossier ecoride
// echo "Application root path: "  .APP_ROOT . "<br>";

// Constante avec le chemin vers le fichier .env.local qui contient les informations de connexion à la base de données
define('APP_ENV', ".env.local");


// BDD relationnelle - MySQL
use App\Db\MySql;

// Je crée une variable où j'appelle la méthode getInstance() de la classe Mysql pour obtenir l'instance de la connexion à la base de données
$mysql = MySql::getInstance();
// J'appelle la méthode getPDO() pour obtenir l'instance de PDO, qui est la classe qui gère la connexion à la base de données
$mysql->getPDO();
// Je vérifie que l'instance de PDO est bien créée et que la connexion à la base de données est établie
var_dump($mysql);


// Routage des requêtes HTTP

use App\Routing\Router;

// On crée une instance du routeur
$router = new Router();

// On gère la requête entrante
// $_SERVER['REQUEST_URI'] contient l'URI de la requête entrante (ex: /user/profile?id=5)
// Le routeur va analyser l'URI, trouver la route correspondante dans le fichier de configuration des routes, instancier le contrôleur et appeler l'action appropriée
// Si la route n'existe pas, le routeur va rediriger vers la page d'erreur 404
$router->handleRequest($_SERVER['REQUEST_URI']);