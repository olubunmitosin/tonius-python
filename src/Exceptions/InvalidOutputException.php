<?php

namespace tonius\python\Exceptions;

use Exception;
use InvalidArgumentException;

class InvalidOutputException extends InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $value
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($value, $code = 0, Exception $previous = null)
    {
        parent::__construct("Invalid output type or file '$value'", $code, $previous);
    }
}
