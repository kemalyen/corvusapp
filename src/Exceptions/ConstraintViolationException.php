<?php namespace Corvus\Exceptions;

use Throwable;
use Exception;
 

class ConstraintViolationException extends Exception
{
    protected $message;

    public function __construct(string $message)
    {
        $this->code      = 500;
        $this->message = $message;
        parent::__construct($this->message, 0);
    }
}