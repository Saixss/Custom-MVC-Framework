<?php


namespace src\Service\User;

use src\DTO\User\UserDTO;

/**
 * Interface UserServiceInterface
 * @package Service\User
 */
interface UserServiceInterface
{
    public function register(UserDTO $data, string $confirmedPass);

    public function login(UserDTO $data): int;

    public function profile(int $userId): UserDTO;

    public function edit(int $userId, UserDTO $data): bool;

    public function getUserById(int $userId): UserDTO;

    public function getUserByName(string $username): UserDTO;
}