<?php


namespace src\Controllers;

use Core\DataBinderInterface;
use Core\TemplateInterface;
use src\DTO\ErrorDTO;

/**
 * Class BaseControllerAbstract
 * @package Controllers
 */
abstract class BaseControllerAbstract
{
    /**
     * @var TemplateInterface
     */
    private TemplateInterface $template;

    /**
     * @var DataBinderInterface|null
     */
    protected ?DataBinderInterface $dataBinder;

    /**
     * @var bool
     */
    private bool $isLogged = false;

    /**
     * BaseControllerAbstract constructor.
     * @param TemplateInterface $template
     * @param DataBinderInterface|null $dataBinder
     */
    public function __construct(TemplateInterface $template, DataBinderInterface $dataBinder = null)
    {
        if (isset($_SESSION['user_id']))
        {
            $this->isLogged = true;
        }
        $this->template = $template;
        $this->dataBinder = $dataBinder;
    }
    
    public function render($templateName, ?array $data = null, ?ErrorDTO $error = null)
    {
        $this->template->render($templateName, $data, $error);
    }

    public function redirect(string $url)
    {
        header("Location: ../$url");
        exit;
    }

    public function isLogged()
    {
        return $this->isLogged;
    }

    public function setSessionId(int $userId)
    {
        $_SESSION["user_id"] = $userId;
    }

    public function getSessionId()
    {
        return $_SESSION["user_id"];
    }
}