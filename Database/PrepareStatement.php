<?php


namespace Database;

use PDOStatement;

/**
 * Class PrepareStatement
 * @package Database
 */
class PrepareStatement implements PrepareStatementInterface
{
    /** @var PDOStatement $pdoStatement */
    private PDOStatement $pdoStatement;

    /**
     * PrepareStatement constructor.
     * @param PDOStatement $pdoStatement
     */
    public function __construct(PDOStatement $pdoStatement)
    {
        $this->pdoStatement = $pdoStatement;
    }

    /**
     * @param array $params
     * @return ResultSetInterface
     */
    public function execute(array $params): ResultSetInterface
    {
        $executeSuccess = $this->pdoStatement->execute($params);
        return new ResultSet($this->pdoStatement, $executeSuccess);
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->pdoStatement->rowCount();
    }
}