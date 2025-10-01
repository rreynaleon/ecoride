<?php

namespace App\Db;

class MySql
{
    // On crée une instance statique de la classe Mysql pour implémenter le design pattern Singleton
    // Cela permet de s'assurer qu'il n'y a qu'une seule instance de la classe, qu'une seule connexion à la base de données
    private static ?self $_instance = null;

    // On déclare des attributs privés pour stocker les informations sensibles de connexion à la base de données
    private string $dbName;
    private string $dbUser;
    private string $dbPassword;
    private string $dbHost;
    private string $dbPort;
    // On instancie PDO, qui est l'objet qui gère la connexion à la base de données
    private ?\PDO $pdo = null;

     private function __construct()
    {
        // Le constructeur est privé pour empêcher l'instanciation directe de la classe

        // La méthode parse_ini_file() permet de lire un fichier de configuration au format INI et de le convertir en tableau associatif
        $dbConf = parse_ini_file(APP_ROOT ."/". APP_ENV);

        // var_dump($dbConf); // Je vérifie le contenu du tableau associatif $dbConf
        
        // Je récupère les informations sensibles de connexion à la base de données qui sont dans le fichier .env
        $this->dbName = $dbConf['db_Name'];
        $this->dbUser = $dbConf['db_User'];
        $this->dbPassword = $dbConf['db_Password'];
        $this->dbHost = $dbConf['db_Host'];
        $this->dbPort = $dbConf['db_Port'];

    }

    
    public static function getInstance(): self
    {
        // La méthode getInstance() est statique et permet d'obtenir l'instance de la classe Mysql
        // Si l'instance n'existe pas, on la crée sinon, on retourne l'instance existante
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function getPDO(): \PDO
    // \PDO est la classe de connexion à la base de données en PHP
    // C'est une classe du PHP Data Objects (PDO) qui permet d'interagir avec différentes bases de données
    {
        if(is_null($this->pdo)) {
            // Si l'instance de PDO n'existe pas, on la crée
            // On utilise le DSN (Data Source Name) pour spécifier le type de base de données, l'hôte, le nom de la base de données et le port
            // On utilise les informations de connexion à la base de données stockées dans les attributs
            // L'user et le mot de passe sont passés en paramètres du constructeur de la classe PDO

                $this->pdo = new \PDO(
                    "mysql:host={$this->dbHost};dbname={$this->dbName};port={$this->dbPort}",
                    $this->dbUser,
                    $this->dbPassword
                );
            }
        // Finalement, cette méthode retourne l'instance de PDO
        return $this->pdo;
    }
}