<?php

namespace Kharlamov\SimpleCrudApp\Controller\Commands;

use Kharlamov\SimpleCrudApp\Controller\Commands\Exceptions\WrongTableException;

class ReadAllSqlCommand extends SqlCommand {

    /**
     * @throws WrongTableException
     */
    protected function readAll(): ReadAllSqlCommand {
        $query = "SELECT * FROM {$this->getTableName()};";
        $this->setResult(
            $this->getDatabaseConnector()
                ->getDatabaseConnection()
                ->query($query)
        );
        if ($this->getResult() === false) { throw new WrongTableException("Wrong table name"); }
        return $this;
    }

    /**
     * @throws WrongTableException
     */
    public function execute(): ReadAllSqlCommand {
        return $this->readAll();
    }
}