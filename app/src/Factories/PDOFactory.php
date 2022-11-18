<?php

namespace App\Factories;

use App\Interfaces\Database;

class PDOFactory implements Database
{
    private string $host;
    private string $port;
    private string $dbName;
    private string $userName;
    private string $password;

    public function __construct(?string $host = null, ?string $dbName = null, ?string $userName = null, ?string $password = null)
    {
        $this->host = $host ?? $_ENV['DB_HOST'];
        $this->port = 3306 ?? $_ENV['DB_PORT'];
        $this->dbName = $dbName ?? $_ENV['DB_NAME'];
        $this->userName = $userName ?? $_ENV['DB_USER'];
        $this->password = $password ?? $_ENV['DB_PASSWORD'];
    }

    public function getMySqlPDO(): \PDO
    {
        return new \PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->dbName, $this->userName, $this->password);
    }

    public function getPostgresPDO(): \PDO
    {
        return new \PDO("postgres:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->password);
    }

    public function getMongoPDO(): \PDO
    {
        return new \PDO("mongo:host=" . $this->host . ";dbname=" . $this->dbName, $this->userName, $this->password);
    }
}
