<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Database\DatabaseConnector;
use mysqli_result;

abstract class SqlCommand {
    private ?DatabaseConnector $databaseConnector;
    private ?string $tableName;

    private mysqli_result|bool $result;

    public function __construct(DatabaseConnector $databaseConnector = null, ?string $tableName = null) {
        $this->databaseConnector = $databaseConnector;
        $this->tableName = $tableName;
    }

    /**
     * @return string|null
     */
    public function getTableName(): ?string {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     * @return SqlCommand
     */
    public function setTableName(string $tableName): SqlCommand {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * @return DatabaseConnector
     */
    public function getDatabaseConnector(): DatabaseConnector {
        return $this->databaseConnector;
    }

    /**
     * @param DatabaseConnector $databaseConnector
     * @return SqlCommand
     */
    public function setDatabaseConnector(DatabaseConnector $databaseConnector): SqlCommand {
        $this->databaseConnector = $databaseConnector;
        return $this;
    }

    abstract public function execute(): SqlCommand;

    /**
     * @return bool|mysqli_result
     */
    public function getResult(): mysqli_result|bool {
        return $this->result;
    }

    /**
     * @param bool|mysqli_result $result
     * @return SqlCommand
     */
    public function setResult(mysqli_result|bool $result): SqlCommand {
        $this->result = $result;
        return $this;
    }
}