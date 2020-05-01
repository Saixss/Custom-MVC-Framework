<?php


namespace Database;

use Generator;

/**
 * Interface ResultSetInterface
 * @package Database
 */
interface ResultSetInterface
{
    public function fetch(string $className);

    public function fetchAll(string $className): Generator ;

    public function getExecuteSuccess(): bool;
}