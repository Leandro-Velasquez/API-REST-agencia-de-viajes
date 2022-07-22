<?php

namespace Class\Static;

class RequestValidator {

    public static function checkRoute(string $method, string $route) {
        
    }

    /**
     * Comprueba si el metodo http enviado en la request se encuentra definido en el servidor
     *
     * @param string $method
     * @return bool
     */
    public static function checkMethod(string $method) {
        return in_array(strtoupper($method), Routes::getAvailableHttpMethods());
    }
}