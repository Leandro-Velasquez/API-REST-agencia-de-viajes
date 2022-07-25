<?php

namespace Class\Static;

class RequestValidator {

    /**
     * Comprueba si la ruta solicitada en la request se encuentra definida en el servidor
     *
     * @param string $method
     * @param string $route
     * @return bool
     */
    public static function checkRoute(string $method, string $route) {
        if(self::checkMethodHttp($method)) {
            foreach(Routes::getAvailableRoutes($method) as $endpoint) {
                if($endpoint === $route) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Comprueba si el metodo http enviado en la request se encuentra definido en el servidor
     *
     * @param string $method
     * @return bool
     */
    public static function checkMethodHttp(string $method) {
        return in_array(strtoupper($method), Routes::getAvailableHttpMethods());
    }
}