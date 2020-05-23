<?php


namespace tonius\python\Exceptions;


use Exception;
use InvalidArgumentException;

class InvalidFileException extends InvalidArgumentException
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
        if (is_null($file)){
            $file = "null";
        }
        parent::__construct("Invalid File Passed file: '$file'. Ensure you're passing in a valid file", $code, $previous);
    }
}
