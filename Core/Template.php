<?php


namespace Core;

use src\DTO\ErrorDTO;

/**
 * Class Template
 * @package Core
 */
class Template implements TemplateInterface
{
    private const TEMPLATE_DIRECTORY = "Templates/";
    private const TEMPLATE_EXT = ".php";

    /**
     * @param string $templateName
     * @param array|null $data
     * @param ErrorDTO|null $error
     */
    public function render(string $templateName, ?array $data = null, ?ErrorDTO $error = null)
    {
        require_once "Templates/common/header.php";
        require_once self::TEMPLATE_DIRECTORY
         . $templateName
         . self::TEMPLATE_EXT;
        require_once "Templates/common/footer.php";
    }
}