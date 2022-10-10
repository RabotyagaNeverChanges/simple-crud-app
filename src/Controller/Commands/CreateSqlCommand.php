<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\EmptyContextException;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\InvalidInsertionException;

class CreateSqlCommand extends SqlCommand {

    /**
     * @throws EmptyContextException
     */
    protected function getKeysAsString(): string {
        $keys = $this->getKeys();
        if (is_null($keys)) {
            throw new EmptyContextException("Keys was not given");
        }
        $queriedKeys = "( ";
        foreach ($keys as $key) {
            $queriedKeys .= "$key, ";
        }
        $queriedKeys = substr($queriedKeys, 0, -2) . ")";
        return $queriedKeys;
    }

    /**
     * @throws EmptyContextException
     */
    protected function getValuesAsString(): string {
        $values = $this->getValues();
        if (is_null($values)) {
            throw new EmptyContextException("Values was not given");
        }

        $queriedValues = "";
        foreach ($values as $row) {
            $queriedValues .= "(";
            foreach ($row as $field) {
                $queriedValues .= "'$field', ";
            }
            $queriedValues = substr($queriedValues, 0, -2) . "), ";
        }
        $queriedValues = substr($queriedValues, 0, -2);
        return $queriedValues;
    }

    /**
     * @throws EmptyContextException
     * @throws InvalidInsertionException
     */
    protected function create(): CreateSqlCommand {
        $query = "INSERT INTO {$this->getTableName()}
            {$this->getKeysAsString()}
            VALUES
            {$this->getValuesAsString()};";
        $this->setResult(
            $this->getDatabaseConnector()
                ->getDatabaseConnection()
                ->query($query)
        );
        if ($this->getResult() === false) { throw new InvalidInsertionException("Unable to query creation"); }
        return $this;
    }

    /**
     * @throws EmptyContextException
     * @throws InvalidInsertionException
     */
    public function execute(): CreateSqlCommand {
        return $this->create();
    }
}