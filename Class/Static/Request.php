<?php
namespace Class\Static;

class Request {

    public static function getService() {

    }

    public static function getId() {

    }

    public static function getHttpMethod() {

    }

    public static function getBody() {

    }

    public static function checkIfThereARequest() {

    }

    private static function getUri() {
        return $_SERVER['REQUEST_URI'];
    }
}