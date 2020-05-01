<?php


namespace Database;

/**
 * Interface DatabaseInterface
 * @package Database
 */
interface DatabaseInterface
{
    public function query(string $query): PrepareStatementInterface;

    public function lastInsertId(): int;
}