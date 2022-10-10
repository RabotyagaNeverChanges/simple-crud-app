<?php

namespace Kharlamov\SimpleCrudApp\Controller;

use Kharlamov\SimpleCrudApp\Controller\Commands\CreateSqlCommand;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\EmptyContextException;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\InvalidInsertionException;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\WrongTableException;
use Kharlamov\SimpleCrudApp\Controller\Commands\ReadAllSqlCommand;
use Kharlamov\SimpleCrudApp\Database\DatabaseConnector;
use mysqli_result;

class Controller {
    private DatabaseConnector $databaseConnector;

    public function __construct(DatabaseConnector $databaseConnector) {
        $this->databaseConnector = $databaseConnector;
    }

    /**
     * @throws EmptyContextException
     * @throws InvalidInsertionException
     */
    public function create(string $tableName, array $keys, array $values): mysqli_result|bool {
        $createCommand = (new CreateSqlCommand(
            $this->databaseConnector,
            $tableName
        ))->setKeys($keys)->setValues($values);

        return $createCommand->execute()
            ->getResult();
    }

    /**
     * @throws WrongTableException
     */
    public function readAll(string $tableName): mysqli_result|bool {
        $readAllCommand = new ReadAllSqlCommand(
            $this->databaseConnector,
            $tableName
        );

        return $readAllCommand->execute()
            ->getResult();
    }

}