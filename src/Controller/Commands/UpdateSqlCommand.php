<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\EmptyContextException;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\InvalidUpdateException;

class UpdateSqlCommand extends SqlCommand {

    private ?array $context = null;
    private ?array $conditions = null;

    /**
     * @return array|null
     */
    public function getContext(): ?array {
        return $this->context;
    }

    /**
     * @param array|null $context
     * @return UpdateSqlCommand
     */
    public function setContext(?array $context): UpdateSqlCommand {
        $this->context = $context;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getConditions(): ?array {
        return $this->conditions;
    }

    /**
     * @param array|null $conditions
     * @return UpdateSqlCommand
     */
    public function setConditions(?array $conditions): UpdateSqlCommand {
        $this->conditions = $conditions;
        return $this;
    }

    protected function getPairsAsString() {
        $context = $this->getContext();
        if (is_null($context)) { throw new EmptyContextException("Context was not given"); }

        $queriedPairs = "";
        foreach ($context as $key => $value) {
            $queriedPairs .= "$key = '$value', ";
        }
        $queriedPairs = substr($queriedPairs, 0, -2);
        return $queriedPairs;
    }

    protected function getConditionsAsString() {
        $conditions = $this->getConditions();
        if (is_null($conditions)) { throw new EmptyContextException("Conditions were not given"); }

        $queriedConditions = "";
        foreach ($conditions as $key => $condition) {
            $queriedConditions .= "$key $condition, ";
        }
        $queriedConditions = substr($queriedConditions, 0 , -2);
        return $queriedConditions;
    }

    /**
     * @throws InvalidUpdateException
     * @throws EmptyContextException
     */
    protected function update(): UpdateSqlCommand {
        $query = "UPDATE {$this->getTableName()} 
            SET {$this->getPairsAsString()}
            WHERE {$this->getConditionsAsString()};";
        $this->setResult(
            $this->getDatabaseConnector()
            ->getDatabaseConnection()
            ->query($query)
        );
        if ($this->getResult() === false) { throw new InvalidUpdateException("Unable to query update") ;}
        return $this;
    }

    /**
     * @throws EmptyContextException
     * @throws InvalidUpdateException
     */
    public function execute(): UpdateSqlCommand {
        return $this->update();
    }
}