<?php
namespace Class\Static;

class Request {

    public static function getService() {
        return self::getUriInArray()['service'];
    }

    public static function getId() {

    }

    public static function getHttpMethod() {

    }

    public static function getBody() {

    }

    public static function checkIfThereARequest() {

    }

    /**
     * Devuelve la uri de la request
     *
     * @return string
     */
    private static function getUri() {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Devuelve la uri de la request en un array donde cada parte de la uri es un elemento del array
     *
     * @return array
     */
    private static function getUriInArray() {
        $keys = array('api', 'service', 'resourceId');
        $values = explode('/', trim(self::getUri(), '/'));
        return array_combine($keys, $values);
    }
}