<?php


namespace Database\ORM;


use Database\ResultSetInterface;

/**
 * Interface QueryBuilderInterface
 * @package Database\ORM
 */
interface QueryBuilderInterface
{
    public function insert(string $table, array $values = []): ResultSetInterface;

    public function update(string $table, array $values = [], array $whereClause = []): ResultSetInterface;

    public function delete(string $table, array $whereClause = []): ResultSetInterface;

    public function select(array $columns = []): QueryBuilderInterface;

    public function from(string $table): QueryBuilderInterface;

    public function where(array $criteria = []): QueryBuilderInterface;

    public function orderBy(array $order): QueryBuilderInterface;

    public function groupBy(array $columns): QueryBuilderInterface;

    public function avg($value): string;

    public function sum($value): string;

    public function min($value): string;

    public function max($value): string;

    public function lastInsertId(): int;

    public function build(): ResultSetInterface;
}