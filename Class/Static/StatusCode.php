<?php

namespace Class\Static;

class StatusCode {

    private static $statusCode;

    public static function getStatusCode() {
        return self::$statusCode;
    }

    public static function setStatusCode($statusCode) {
        self::$statusCode = $statusCode;
    }
}

?>