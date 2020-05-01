<?php


namespace Database\ORM\Repository;


/**
 * Interface RepositoryInterface
 * @package Database\ORM\Repository
 */
interface RepositoryInterface
{
    public function findAll(array $orderBy = []): \Generator;

    public function findBy(array $where, array $orderBy = []): \Generator;

    public function findOne($primaryKey);
}