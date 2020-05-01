<?php

namespace Core\Mvc;

/**
 * Interface MvcContextInterface
 * @package Core\Mvc
 */
interface MvcContextInterface
{
    public function getControllerName(): string ;
    public function setControllerName(string $controllerName): void ;
    public function getActionName(): string ;
    public function setActionName(string $actionName): void ;
    public function getParams(): array ;
    public function setParams($params): void ;
    public function getRequestPath(): string ;
}