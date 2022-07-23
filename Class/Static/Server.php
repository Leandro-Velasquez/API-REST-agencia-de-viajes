<?php

namespace Class\Static;

class Server {

    private static $maxLengthId = 7;

    /**
     * Obtiene el metodo http de la request
     *
     * @return string
     */
    public static function getHttpMethod() {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Obtiene el body de la request
     *
     * @return array
     */
    public static function getBody() {
        $raw = file_get_contents('php://input');
        return Json::convertirJsonAFormatoArrayAsociativo($raw);
    }

    /**
     * Devuelve la uri de la request, si le pasamos true como argumento nos devuelve la uri completa incluido el directorio del proyecto
     *
     * @return string
     */
    public static function getUri(bool $boolean=false) {
        if(!$boolean) {
            return preg_replace('/'.'^\/.*?\/'.'/', '', $_SERVER['REQUEST_URI']);
        }
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Obtiene el nombre del servicio(clase) que fue llamado
     *
     * @return string
     */
    public static function getController() {
        return self::getUriInArray()['controller'];
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
        return null;
    }

    /**
     * Devuelve la uri de la request en un array donde cada parte de la uri es un elemento del array
     *
     * @return array
     */
    private static function getUriInArray() {
        $keys = [];
        $values = explode('/', trim(self::getUri(), '/'));
        switch(count($values)) {
            case 1:
                array_push($keys, 'controller');
                break;
            case 2:
                array_push($keys, 'service', 'id');
                break;
            case 3:
                array_push($keys, 'service', 'id', 'action');
                break;
        }
        return array_combine($keys, $values);
    }
}

?>