<?php

namespace Core\Mvc;

/**
 * Class MvcContext
 * @package Core\Mvc
 */
class MvcContext implements MvcContextInterface
{

    private string $controllerName;
    private string $actionName;
    private array $params = [];
    private string $requestPath;

    /**
     * MvcContext constructor.
     * @param string $controllerName
     * @param string $actionName
     * @param array $params
     * @param string $requestPath
     */
    public function __construct(string $controllerName, string $actionName, array $params, string $requestPath)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;
        $this->requestPath = $requestPath;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * @param string $controllerName
     */
    public function setControllerName(string $controllerName): void
    {
        $this->controllerName = $controllerName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * @param string $actionName
     */
    public function setActionName(string $actionName): void
    {
        $this->actionName = $actionName;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param $params
     */
    public function setParams($params): void
    {
        $this->params[] = $params;
    }

    /**
     * @return string
     */
    public function getRequestPath(): string
    {
        return $this->requestPath;
    }

}