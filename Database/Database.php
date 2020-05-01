<?php


namespace Database;

use PDO;

/**
 * Class Database
 * @package Database
 */
class Database implements DatabaseInterface
{
    /** @var PDO $pdo */
    private PDO $pdo;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $dsn = parse_ini_file("Config\db.ini");
        $pdo = new \PDO($dsn["dsn"], $dsn["user"], $dsn["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @return PrepareStatementInterface
     */
    public function query(string $query): PrepareStatementInterface
    {
        $prepareStm = $this->pdo->prepare($query);
        return new PrepareStatement($prepareStm);
    }

    /**
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
}