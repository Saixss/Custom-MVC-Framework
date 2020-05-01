<?php


namespace Database\ORM;


use Database\DatabaseInterface;
use Database\ResultSetInterface;

/**
 * Class MySQLQueryBuilder
 * @package Database\ORM
 */
class MySQLQueryBuilder implements QueryBuilderInterface
{
    /**
     * @var string
     */
    private string $query;

    /**
     * @var array
     */
    private array $whereClause = [];

    /**
     * @var DatabaseInterface
     */
    public DatabaseInterface $db;

    /**
     * MySQLQueryBuilder constructor.
     * @param DatabaseInterface $db
     */
    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->query = "";
    }

    /**
     * @param string $table
     * @param array $values
     * @return ResultSetInterface
     */
    public function insert(string $table, array $values = []): ResultSetInterface
    {
        $query = "INSERT INTO $table (" . implode(", ", array_keys($values))
            . ") VALUES (" . implode(", ", array_fill(0, count($values), "?")) . ")";

        return $this->db->query($query)
            ->execute(array_values($values));
    }

    /**
     * @param string $table
     * @param array $values
     * @param array $whereClause
     * @return ResultSetInterface
     */
    public function update(string $table, array $values = [], array $whereClause = []): ResultSetInterface
    {
         $query = "UPDATE $table SET ";

         foreach (array_keys($values) as $columnName) {

             $query .= "$columnName = ?, ";
         }

         $query = rtrim($query, ", ");
         $query .= ' WHERE 1=1';

         foreach (array_keys($whereClause) as $column) {

            $query .= " AND $column = ?";
         }

         return $this->db
             ->query($query)
             ->execute(array_merge(array_values($values), array_values($whereClause)));
    }

    /**
     * @param string $table
     * @param array $whereClause
     * @return ResultSetInterface
     */
    public function delete(string $table, array $whereClause = []): ResultSetInterface
    {
         $query = "DELETE FROM $table WHERE 1=1";

         foreach (array_keys($whereClause) as $column) {

             $query .= " AND $column = ?";
         }

         return $this->db
             ->query($query)
             ->execute(array_values($whereClause));
    }


    /**
     * @param array $columns
     * @return QueryBuilderInterface
     */
    public function select(array $columns = []): QueryBuilderInterface
    {
        $query = "SELECT ";

        if (empty($columns)) {
            $query .= "* ";
        } else {
            $query .= implode(", ", $columns);
        }

        $this->query = $query;

        return $this;
    }

    /**
     * @param string $table
     * @return QueryBuilderInterface
     */
    public function from(string $table): QueryBuilderInterface
    {
        $this->query .= " FROM $table";

        return $this;
    }

    /**
     * @param array $criteria
     * @return QueryBuilderInterface
     */
    public function where(array $criteria = []): QueryBuilderInterface
    {
        $query = " WHERE 1=1 ";

        foreach (array_keys($criteria) as $column) {

            $query .= "AND " . $column . " = ?";
        }

        $this->query .= $query;
        $this->whereClause = array_values($criteria);

        return $this;
    }

    /**
     * @param array $order
     * @return QueryBuilderInterface
     */
    public function orderBy(array $order): QueryBuilderInterface
    {
        $query = " ORDER BY ";

        if(count(array_filter(array_keys($order), "is_string")) > 0){
            foreach ($order as $column => $criterion) {

                $query .= $column . " " . $criterion . ", ";
            }
        } else {
            foreach ($order as $column) {

                $query .= $column . ", ";
            }
        }

        $query = rtrim($query,", ");

        $this->query .= $query;

        return $this;
    }

    /**
     * @param array $columns
     * @return QueryBuilderInterface
     */
    public function groupBy(array $columns): QueryBuilderInterface
    {
        $this->query .= " GROUP BY " . implode(", ", $columns);

        return $this;
    }

    /**
     * @param $value
     * @return string
     */
    public function avg($value): string
    {
        return "AVG($value)";
    }

    /**
     * @param $value
     * @return string
     */
    public function sum($value): string
    {
        return "SUM($value)";
    }

    /**
     * @param $value
     * @return string
     */
    public function min($value): string
    {
        return "MIN($value)";
    }

    /**
     * @param $value
     * @return string
     */
    public function max($value): string
    {
        return "MAX($value)";
    }

    /**
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->db->lastInsertId();
    }

    /**
     * @return ResultSetInterface
     */
    public function build(): ResultSetInterface
    {
        return $this->db->query($this->query)->execute($this->whereClause);
    }
}