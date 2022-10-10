<?php

namespace Kharlamov\SimpleCrudApp\Controller;

use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\WrongTableException;
use Kharlamov\SimpleCrudApp\Controller\Commands\ReadAllSqlCommand;
use Kharlamov\SimpleCrudApp\Database\DatabaseConnector;

class Controller {
    private DatabaseConnector $databaseConnector;

    public function __construct(DatabaseConnector $databaseConnector) {
        $this->databaseConnector = $databaseConnector;
    }

    /**
     * @throws WrongTableException
     */
    public function readAll(string $tableName): array {
        $readAllCommand = new ReadAllSqlCommand(
            $this->databaseConnector,
            $tableName
        );

        return $readAllCommand->execute()
            ->getResult()
            ->fetch_array(MYSQLI_ASSOC);
    }

}