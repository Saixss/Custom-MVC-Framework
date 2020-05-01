<?php

namespace Exception;

use Throwable;

/**
 * Class RouteException
 * @package Exception
 */
class RouteException extends \Exception
{
    private string $routeName;

    public function __construct($routeName, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->routeName = $routeName;
    }

    public function getRoute()
    {
        return $this->routeName;
    }
}