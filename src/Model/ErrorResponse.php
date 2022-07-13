<?php

namespace App\Model;

class ErrorResponse
{
    public function __construct(private string $message)
    {
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
