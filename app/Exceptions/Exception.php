<?php

namespace App\Exceptions;

class Exception extends \Exception
{
    public $messages;

    public function __construct($message, \Throwable $previous = null)
    {
        parent::__construct($this->messages[$message] ?? substr($message, 3), substr($message, 0, 3), $previous);
    }
}
