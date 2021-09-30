<?php namespace Corvus\Exceptions;

use Throwable;
use Exception;
/**
 * Class GeneralException
 *
 */

class GeneralException extends Exception
{
    protected $message;

    public function __construct(Exception $exception)
    {
        $this->code      = (!empty($exception->getCode())) ? $exception->getCode() : 500;
        $this->message = $exception->getMessage();
        parent::__construct($exception->getMessage(), 0, $exception);
    }
}
