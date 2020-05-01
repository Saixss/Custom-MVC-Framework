<?php


namespace src\Controllers;


use Core\TemplateInterface;
use src\DTO\User\UserDTO;

/**
 * Class HomeController
 * @package Controllers
 */
class HomeController extends BaseControllerAbstract
{
    /**
     * HomeController constructor.
     * @param TemplateInterface $template
     */
    public function __construct(TemplateInterface $template)
    {
        parent::__construct($template);
    }

    public function index()
    {
        if ($this->isLogged())
        {
            $this->render("home");
        } else
        {
            $this->render("guest");
        }
    }
}