<?php namespace Markard\GridData\Exceptions;


use Exception;

class InvalidOrderException extends Exception
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct('Invalid sort order was sent. Valid orders are: Markard\GridData\Sort::ORDER_DESC, Markard\GridData\Sort::ORDER_ASC. Case not important.');
    }
}