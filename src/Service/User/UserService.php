<?php


namespace src\Service\User;


use Exception;
use src\DTO\User\UserDTO;
use src\Repository\User\UserRepositoryInterface;

/**
 * Class UserService
 * @package Service\User
 */
class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface $userRepository
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserDTO $data
     * @param string $confirmedPass
     * @return bool
     * @throws Exception
     */
    public function register(UserDTO $data, string $confirmedPass)
    {
        $existentUser = $this->userRepository->getUserByName($data->getUsername());

        if ($existentUser)
        {
            throw new Exception("Username already exists");
        }

        $this->validateFields($data);

        if ($data->getPassword() !== $confirmedPass)
        {
            throw new Exception("Password mismatch");
        }

        $this->encryptPassword($data);

        return $this->userRepository->insertUser($data);
    }

    /**
     * @param UserDTO $data
     * @return int
     * @throws Exception
     */
    public function login(UserDTO $data): int
    {
        $loginUserPass = $data->getPassword();
        $baseUser = $this->userRepository->getUserByName($data->getUsername());

        if ($baseUser === null)
        {
            throw new Exception("Username not exists");
        }

        $isPassCorrect = password_verify($loginUserPass, $baseUser->getPassword());

        if ($isPassCorrect === false)
        {
            throw new Exception("Incorrect password");
        }

        return $baseUser->getUserId();
    }

    /**
     * @param int $userId
     * @return UserDTO
     */
    public function profile(int $userId): UserDTO
    {
        return $this->userRepository->getUserById($userId);
    }

    /**
     * @param int $userId
     * @param UserDTO $data
     * @return bool
     * @throws Exception
     */
    public function edit(int $userId, UserDTO $data): bool
    {
        $currentUser = $this->userRepository->getUserById($userId);
        $existentUser = $this->userRepository->getUserByName($data->getUsername());

        if ($existentUser && $currentUser->getUsername() !== $existentUser->getUsername())
        {
            throw new Exception("Username already exists");
        }

        $this->validateFields($data);

        $this->encryptPassword($data);
        $success = $this->userRepository->update($userId, $data);
        return $success;
    }

    /**
     * @param int $userId
     * @return UserDTO
     */
    public function getUserById(int $userId): UserDTO
    {
        return $this->userRepository->getUserById($userId);
    }

    /**
     * @param string $username
     * @return UserDTO
     */
    public function getUserByName(string $username): UserDTO
    {
        return $this->userRepository->getUserByName($username);
    }

    /**
     * @param UserDTO $user
     */
    private function encryptPassword(UserDTO $user)
    {
        $plainPassword = $user->getPassword();
        $encryptedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        $user->setPassword($encryptedPassword);
    }

    /**
     * @param UserDTO $data
     * @throws Exception
     */
    private function validateFields(UserDTO $data): void
    {
        if ($data->getUsername() === "") {
            throw new Exception("Empty Username Field");
        }

        if ($data->getPassword() === "") {
            throw new Exception("Empty Password field");
        }

        if ($data->getFirstName() === "") {
            throw new Exception("Empty First Name field");
        }

        if ($data->getLastName() === "") {
            throw new Exception("Empty Last Name field");
        }
    }
}