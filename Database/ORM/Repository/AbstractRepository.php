<?php


namespace Database\ORM\Repository;


use Database\ORM\QueryBuilderInterface;

/**
 * Class AbstractRepository
 * @package Database\ORM\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    private string $entity;

    /**
     * @var string
     */
    private string $table;

    /**
     * @var string
     */
    private string $primaryKey;

    /**
     * @var RepositoryInterface[]
     */
    private array $relatedPluralRepositories;

    /**
     * @var RepositoryInterface[]
     */
    private array $relatedSingularRepositories;

    /**
     * @var QueryBuilderInterface
     */
    protected QueryBuilderInterface $queryBuilder;

    /**
     * AbstractRepository constructor.
     * @param string $entity
     * @param string $table
     * @param string $primaryKey
     * @param RepositoryInterface[] $relatedPluralRepositories
     * @param RepositoryInterface[] $relatedSingularRepositories
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(string $entity, string $table, string $primaryKey, array $relatedPluralRepositories, array $relatedSingularRepositories, QueryBuilderInterface $queryBuilder)
    {
        $this->entity = $entity;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->relatedPluralRepositories = $relatedPluralRepositories;
        $this->relatedSingularRepositories = $relatedSingularRepositories;
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @param array $orderBy
     * @return \Generator
     */
    public function findAll(array $orderBy = []): \Generator
    {
        $builder = $this->queryBuilder
            ->select()
            ->from($this->table);

        if (!empty($orderBy)) {
            $builder = $builder->orderBy($orderBy);
        }

        $result = $builder
            ->build()
            ->fetchAll($this->entity);

        foreach ($result as $entity) {
            yield $this->populateNavigationProperties($entity);
        }
    }

    /**
     * @param array $where
     * @param array $orderBy
     * @return \Generator
     */
    public function findBy(array $where, array $orderBy = []): \Generator
    {
        $builder = $this->queryBuilder
            ->select()
            ->from($this->table)
            ->where($where);

        if (!empty($orderBy)) {
            $builder = $builder->orderBy($orderBy);
        }

        $result = $builder
            ->build()
            ->fetchAll($this->entity);

        foreach ($result as $entity) {
            yield $this->populateNavigationProperties($entity);
        }
    }

    /**
     * @param $primaryKey
     * @return mixed
     */
    public function findOne($primaryKey)
    {
        $result = $this->queryBuilder
            ->select()
            ->from($this->table)
            ->where([$this->primaryKey => $primaryKey])
            ->build()
            ->fetch($this->entity);

        return $this->populateNavigationProperties($result);
    }

    /**
     * @param $entity
     * @return mixed
     */
    public function populateNavigationProperties($entity)
    {
            foreach ($this->relatedSingularRepositories as $key => $repository) {
                $setter = "set" . ucfirst(implode("", explode("_", $key)));
                $foreignKey = rtrim($this->table, "s") . "_id";
                $getter = "get" . ucfirst($this->primaryKey);
                $relatedObject = $repository->findBy([$foreignKey => $entity->$getter()]);
                $relatedObject->current();
                $entity->$setter($relatedObject);
            }

            foreach ($this->relatedPluralRepositories as $key => $repository) {
                $setter = "set" . ucfirst($key);
                $foreignKey = rtrim($this->table, "s") . "_id";
                $getter = "get" . ucfirst($this->primaryKey);
                $relatedObject = $repository->findBy([$foreignKey => $entity->$getter()]);
                $entity->$setter($relatedObject);
            }

            return $entity;
    }

}