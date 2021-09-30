<?php namespace Corvus\Exceptions;

use Throwable;
use Exception;
/**
 * Class OrderRequiresException
 *
 */

class UniqueUserEmailException extends Exception
{
    protected $message;

    public function __construct(string $message)
    {
        $this->code      = 403;
        $this->message = $message;
        parent::__construct($this->message, 0);
    }
}
