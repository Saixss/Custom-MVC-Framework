<?php


namespace Core;


use Core\Mvc\MvcContextInterface;
use Exception\RouteException;

/**
 * Class Application
 * @package Core
 */
class Application
{
    /**
     * @var array
     */
    private array $dependencies = [];

    /**
     * @var array
     */
    private array $resolvedDependencies = [];

    /**
     * @var MvcContextInterface
     */
    private MvcContextInterface $mvcContext;

    /**
     * Application constructor.
     * @param MvcContextInterface $mvcContext
     */
    public function __construct(MvcContextInterface $mvcContext)
    {
        $this->mvcContext = $mvcContext;
        $this->dependencies[MvcContextInterface::class] = get_class($mvcContext);
        $this->resolvedDependencies[get_class($mvcContext)] = $mvcContext;
    }

    public function start()
    {
        $controllerName = $this->mvcContext->getControllerName();
        $actionName = $this->mvcContext->getActionName();
        $controllerFullQualifiedName = "src\Controllers\\".ucfirst($controllerName)."Controller";

        $this->routeExists($controllerFullQualifiedName, $actionName);

        $controller = $this->resolve($controllerFullQualifiedName);

        $refMethod = new \ReflectionMethod($controller, $actionName);
        $refParams = $refMethod->getParameters();
        $urlParamsCount = count($this->mvcContext->getParams());

        for ($i = $urlParamsCount; $i < count($refParams); $i++)
        {
            $argument = $refParams[$i];

            $argumentInterface = $argument->getClass()->getName();

            if (array_key_exists($argumentInterface, $this->dependencies))
            {
                $argumentClass = $this->dependencies[$argumentInterface];
                $this->mvcContext->setParams($this->resolve($argumentClass));
            } else {
                $bindingModel = new $argumentInterface;
                $dataBinder = new DataBinder();

                $bindingModel = $dataBinder->bind($_POST, $bindingModel);
                $this->mvcContext->setParams($bindingModel);
            }
        }

        call_user_func_array([$controller, $actionName], $this->mvcContext->getParams());
    }

    public function registerDependency(string $abstraction, string $implementation)
    {
        $this->dependencies[$abstraction] = $implementation;
    }

    public function resolve($className)
    {
        if (array_key_exists($className, $this->resolvedDependencies))
        {
            return $this->resolvedDependencies[$className];
        }

        $refClass = new \ReflectionClass($className);
        $constructor = $refClass->getConstructor();

        if ($constructor === null)
        {
            $object = new $className;
            $this->resolvedDependencies[$className] = $object;
            return $object;
        }

        $parameters = $constructor->getParameters();
        $arguments = [];

        foreach ($parameters as $parameter)
        {
            $dependencyInterface = $parameter->getClass();
            $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
            $arguments[] = $this->resolve($dependencyClass);
        }

        $object = $refClass->newInstanceArgs($arguments);
        $this->resolvedDependencies[$className] = $object;

        return $object;
    }

    /**
     * @param string $controllerFullQualifiedName
     * @param string $actionName
     * @throws RouteException
     */
    public function routeExists(string $controllerFullQualifiedName, string $actionName)
    {
        $msg = $this->mvcContext->getRequestPath();

        if (class_exists($controllerFullQualifiedName) === false)
        {
            throw new RouteException($msg);
        }

        else if(method_exists($controllerFullQualifiedName, $actionName) === false)
        {
            throw new RouteException($msg);
        }
    }
}