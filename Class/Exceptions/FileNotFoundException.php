<?php
namespace Class\Exceptions;

use Exception;

class FileNotFoundException extends Exception {
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
?>