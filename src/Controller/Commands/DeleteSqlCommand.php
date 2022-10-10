<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\EmptyContextException;
use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\IllegalDeleteException;

class DeleteSqlCommand extends SqlCommand {

    private ?array $conditions = null;

    /**
     * @return array|null
     */
    public function getConditions(): ?array {
        return $this->conditions;
    }

    /**
     * @param array|null $conditions
     * @return DeleteSqlCommand
     */
    public function setConditions(?array $conditions): DeleteSqlCommand {
        $this->conditions = $conditions;
        return $this;
    }

    /**
     * @throws EmptyContextException
     */
    private function getConditionsAsString(): string {
        $conditions = $this->getConditions();
        if (is_null($conditions)) {throw new EmptyContextException("Conditions were not given"); }

        $queriedConditions = "";
        foreach ($conditions as $key => $condition) {
            $queriedConditions .= "$key $condition, ";
        }
        $queriedConditions = substr($queriedConditions, 0, -2);
        return $queriedConditions;
    }

    /**
     * @throws IllegalDeleteException
     * @throws EmptyContextException
     */
    protected function delete(): DeleteSqlCommand {
        $query = "DELETE FROM {$this->getTableName()}
            WHERE {$this->getConditionsAsString()};";
        $this->setResult(
            $this->getDatabaseConnector()
                ->getDatabaseConnection()
                ->query($query)
        );
        if ($this->getResult() === false) { throw new IllegalDeleteException("Unable to query deletion"); }
        return $this;
    }

    /**
     * @throws IllegalDeleteException
     * @throws EmptyContextException
     */
    public function execute(): DeleteSqlCommand {
        return $this->delete();
    }
}