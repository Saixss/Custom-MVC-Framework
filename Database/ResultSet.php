<?php


namespace Database;

use Core\DataBinder;
use PDOStatement;
use Generator;

/**
 * Class ResultSet
 * @package Database
 */
class ResultSet implements ResultSetInterface
{
    /** @var PDOStatement $pdoStatement */
    private PDOStatement $pdoStatement;

    private bool $executeSuccess;

    /**
     * ResultSet constructor.
     * @param PDOStatement $pdoStatement
     * @param bool $executeSuccess
     */
    public function __construct(PDOStatement $pdoStatement, bool $executeSuccess)
    {
        $this->pdoStatement = $pdoStatement;
        $this->executeSuccess = $executeSuccess;
    }

    /**
     * @param string $className
     * @return object
     */
    public function fetch(string $className): object
    {
        $result = $this->pdoStatement->fetch(\PDO::FETCH_ASSOC);

        $dataBinder = new DataBinder();
        $object = new $className;
        $result = $dataBinder->bind($result, $object);

        if ($result === false)
        {
            return null;
        } else {
            return $result;
        }
    }

    /**
     * @param string $className
     * @return Generator
     */
    public function fetchAll(string $className): Generator
    {
        $dataBinder = new DataBinder();
        $object = new $className;

        while($row = $this->pdoStatement->fetch(\PDO::FETCH_ASSOC)) {
            yield  $dataBinder->bind($row, $object);
        }
    }

    /**
     * @return bool
     */
    public function getExecuteSuccess(): bool
    {
        return $this->executeSuccess;
    }
}