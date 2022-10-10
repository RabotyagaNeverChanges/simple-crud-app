<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Database\DatabaseConnector;
use mysqli_result;

abstract class SqlCommand {
    private ?DatabaseConnector $databaseConnector;
    private ?string $tableName;

    private ?array $keys;
    private ?array $values;

    private mysqli_result|bool $result;

    public function __construct(DatabaseConnector $databaseConnector = null,
                                ?string $tableName = null,
                                ?array $keys= null,
                                ?array $values = null,
    ) {
        $this->databaseConnector = $databaseConnector;
        $this->tableName = $tableName;
        $this->keys = $keys;
        $this->values = $values;
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

    /**
     * @param array|null $keys
     * @return SqlCommand
     */
    public function setKeys(?array $keys): SqlCommand {
        $this->keys = $keys;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getKeys(): ?array {
        return $this->keys;
    }

    /**
     * @param array|null $values
     * @return SqlCommand
     */
    public function setValues(?array $values): SqlCommand {
        $this->values = $values;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getValues(): ?array {
        return $this->values;
    }

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

    abstract public function execute(): SqlCommand;
}