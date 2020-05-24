<?php

namespace tonius\python\Exceptions;

use Exception;
use InvalidArgumentException;

class DoesNotExistException extends InvalidArgumentException
{
    /**
     * Constructor.
     *
     * @param string $file
     * @param int $code
     * @param Exception $previous
     */
    public function __construct($file, $code = 0, Exception $previous = null)
    {
        parent::__construct("file: '$file' doesn't exist. Please check that the file or path exist in the required directory.", $code, $previous);
    }
}
