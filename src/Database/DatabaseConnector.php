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
        Dotenv::createImmutable(PROJECT_ROOT)->safeLoad();
        $this->databaseConnection = mysqli_connect(
            hostname: getenv("DB_HOST"),
            username: getenv("DB_USER"),
            password: getenv("DB_PASSWORD"),
            database: getenv("DB_NAME"),
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