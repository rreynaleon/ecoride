<?php

namespace App\Repository;

use App\Db\MySql;

class Repository
{
    protected \PDO $pdo;

    public function __construct()
    {
        $this->pdo = MySql::getInstance()->getPDO();

    }
}