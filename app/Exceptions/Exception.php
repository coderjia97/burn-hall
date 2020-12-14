<?php
/**
 * Sunny 2020/12/14 下午1:51
 * ogg sit down and start building bugs.
 * Author: Ogg <baoziyoo@gmail.com>
 */

namespace App\Exceptions;

class Exception extends \Exception
{
    public $messages;

    public function __construct($message, \Throwable $previous = null)
    {
        parent::__construct($this->messages[$message] ?? substr($message, 3), substr($message, 0, 3), $previous);
    }
}
