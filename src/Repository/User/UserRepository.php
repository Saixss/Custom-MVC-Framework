<?php


namespace src\Repository\User;

use DataBase\ORM\QueryBuilderInterface;
use DataBase\ORM\Repository\AbstractRepository;
use src\DTO\User\UserDTO;

/**
 * Class UserRepository
 * @package Repository\User
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(QueryBuilderInterface $queryBuilder)
   {
       parent::__construct(UserDTO::class, "users", "user_id", [], [], $queryBuilder);
   }

    /**
     * @param UserDTO $user
     * @return boolean
     */
    public function insertUser(UserDTO $user): bool
    {
        $this->queryBuilder->insert("users",
            ["username" => $user->getUsername(),
                "password" => $user->getPassword(),
                "first_name" => $user->getFirstName(),
                "last_name" => $user->getLastName()]);

        return $this->queryBuilder->lastInsertId();
    }

    /**
     * @param int $userId
     * @param UserDTO $user
     * @return bool
     */
    public function update(int $userId, UserDTO $user): bool
    {
        return $this->queryBuilder
            ->update("users", ["username" => $user->getUsername(),
                      "password" => $user->getPassword(),
                      "first_name" => $user->getFirstName(),
                      "last_name" => $user->getLastName()], ["user_id" => $userId])
            ->getExecuteSuccess();
    }

    /**
     * @param int $id
     * @return UserDTO|null
     */
    public function getUserById(int $id): ?UserDTO
    {
        return $this->findOne($id);
    }

    /**
     * @param string $name
     * @return UserDTO|null
     */
    public function getUserByName(string $name): ?UserDTO
    {
        return $this->findBy(["username" => $name])->current();
    }
}