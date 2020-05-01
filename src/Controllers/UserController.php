<?php


namespace src\Controllers;

use Core\DataBinderInterface;
use Core\TemplateInterface;
use Exception;
use src\DTO\ErrorDTO;
use src\DTO\User\UserDTO;
use src\Service\User\UserServiceInterface;

/**
 * Class UserController
 * @package Controllers
 */
class UserController extends BaseControllerAbstract
{
    /**
     * @var UserServiceInterface $userService
     */
    private UserServiceInterface $userService;

    /**
     * UserController constructor.
     * @param UserServiceInterface $userService
     * @param TemplateInterface $template
     * @param DataBinderInterface $dataBinder
     */
    public function __construct(UserServiceInterface $userService, TemplateInterface $template, DataBinderInterface $dataBinder)
    {
        parent::__construct($template, $dataBinder);
        $this->userService = $userService;
    }

    public function register(UserDTO $userData)
    {
        if ($this->isLogged()) {
            $this->redirect("");
        }

        if (isset($_POST["btnRegister"]))
        {
            try {
                $this->userService->register($userData, $_POST["confirm_password"]);
                $this->redirect("user/login");
            } catch (Exception $e) {
                $this->render("user/register", null, new ErrorDTO($e->getMessage()));
            }
        } else
        {
            $this->render("user/register");
        }
    }

    public function login(UserDTO $userData)
    {
        if ($this->isLogged()) {
            $this->redirect("");
        }

        if (isset($_POST["btnLogin"]))
        {
            try {
                $userId = $this->userService->login($userData);
                $this->setSessionId($userId);
                $this->redirect("");
            } catch (Exception $e) {
                $this->render("user/login", null, new ErrorDTO($e->getMessage()));
            }
        } else
        {
            $this->render("user/login");
        }
    }

    public function edit(UserDTO $userData)
    {
        if ($this->isLogged() === false)
        {
            $this->redirect("");
        }

        if (isset($_POST["btnEdit"]))
        {
            try {
                $this->userService->edit($this->getSessionId(), $userData);
                $this->redirect("user/profile");
            } catch (Exception $e) {
                $this->render("user/edit", [$userData], new ErrorDTO($e->getMessage()));
            }
        } else
        {
            $user = $this->userService->getUserById($this->getSessionId());
            $this->render("user/edit", [$user]);
        }
    }

    public function profile()
    {
        if ($this->isLogged() === false)
        {
            $this->redirect("");
        }

        $user = $this->userService->profile($this->getSessionId());
        $this->render("user/profile", [$user]);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect("");
    }
}