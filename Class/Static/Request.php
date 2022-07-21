<?php
namespace Class\Static;

class Request {

    private static $maxLengthId = 7;

    /**
     * Obtiene el nombre del servicio(clase) que fue llamado
     *
     * @return string
     */
    public static function getService() {
        return self::getUriInArray()['service'];
    }

    /**
     * Obtiene el id del recurso solicitado en la request
     *
     * @return string
     */
    public static function getId() {
        if(is_numeric(self::getUriInArray()['id']) && !(strpos(self::getUriInArray()['id'], '.') || strpos(self::getUriInArray()['id'], ',')) && strlen(self::getUriInArray()['id']) <= self::$maxLengthId) {
            return self::getUriInArray()['id'];
        }
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
        $keys = array('api', 'service', 'id');
        $values = explode('/', trim(self::getUri(), '/'));
        return array_combine($keys, $values);
    }
}