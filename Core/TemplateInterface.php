<?php


namespace Core;

use src\DTO\ErrorDTO;

/**
 * Interface TemplateInterface
 * @package Core
 */
interface TemplateInterface
{
    public function render(string $templateName, ?array $data = null, ?ErrorDTO $error = null);
}