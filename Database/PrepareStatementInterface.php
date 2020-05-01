<?php


namespace Database;

/**
 * Interface PrepareStatementInterface
 * @package Database
 */
interface PrepareStatementInterface
{
    public function execute(array $params): ResultSetInterface;

    public function rowCount();
}