<?php

namespace src\DTO;

/**
 * Class ErrorDTO
 * @package src\DTO
 */
class ErrorDTO
{
    /**
     * @var string
     */
    private string $msg;

    /**
     * ErrorDTO constructor.
     * @param string $msg
     */
    public function __construct(string $msg)
    {
        $this->msg = $msg;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->msg;
    }
}