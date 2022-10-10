<?php

namespace Kharlamov\SimpleCrudApp\Database;

use Kharlamov\SimpleCrudApp\Database\Exceptions\ConnectionException;
use mysqli;
use Dotenv\Dotenv;

class DatabaseConnector {
    protected mysqli $databaseConnection;

    /**
     * @throws ConnectionException
     */
    public function __construct() {
        require_once "config/project_config.php";
        $dotenv = Dotenv::createImmutable(PROJECT_ROOT)->load();
        $this->databaseConnection = new mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_NAME'],
        );
        if ($this->databaseConnection->connect_error) {
            throw new ConnectionException("Unable to connect to database");
        }
    }

    /**
     * @return mysqli
     */
    public function getDatabaseConnection(): mysqli {
        return $this->databaseConnection;
    }

}