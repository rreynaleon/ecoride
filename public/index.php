<?php

echo "Hello, EcoRide !". "<br>";
echo "La connection à la base de données a réussi !";

// Inclus le fichier d'autoload de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// On définit une constante avec le chemin de base de l'application parce que l'on va l'utiliser dans plusieurs fichiers pour inclure des fichiers
// la méthode dirname(__DIR__) permet de remonter d'un niveau dans l'arborescence des dossiers
define('APP_ROOT', dirname(__DIR__));
// Par exemple si le fichier index.php est dans le dossier public, dirname(__DIR__) renvoie le chemin du dossier parent, qui est le dossier ecoride
// echo "Application root path: "  .APP_ROOT . "<br>";

// Constante avec le chemin vers le fichier .env.local qui contient les informations de connexion à la base de données
define('APP_ENV', ".env.local");

use App\Db\MySql;

// Je crée une variable où j'appelle la méthode getInstance() de la classe Mysql pour obtenir l'instance de la connexion à la base de données
$mysql = MySql::getInstance();
// J'appelle la méthode getPDO() pour obtenir l'instance de PDO, qui est la classe qui gère la connexion à la base de données
$mysql->getPDO();
// Je vérifie que l'instance de PDO est bien créée et que la connexion à la base de données est établie
var_dump($mysql);