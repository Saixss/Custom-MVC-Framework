<?php

namespace src\Repository\User;

use src\DTO\User\UserDTO;

/**
 * Interface UserRepositoryInterface
 * @package Repository\User
 */
interface UserRepositoryInterface
{
    public function insertUser(UserDTO $user): bool;

    public function update(int $userId, UserDTO $user): bool;

    public function getUserById(int $id): ?UserDTO;

    public function getUserByName(string $name): ?UserDTO;
}