<?php

namespace App\Database;

use PDO;
class DatabaseConnection
{
    public ?PDO $pdo = null;

    public function dbConnect(): PDO
    {
        if ($this->pdo == null) {
            // Database variables
            $dsn = 'mysql:dbname=' . $_ENV['database_name'] . ';host=' . $_ENV['database_host'] . ';port=3306';
            $username = $_ENV['database_user'];
            $password = $_ENV['database_password'];

            // Request to mariadb sql database
            $this->pdo = new PDO($dsn, $username, $password);
        }
        return $this->pdo;
    }
}
