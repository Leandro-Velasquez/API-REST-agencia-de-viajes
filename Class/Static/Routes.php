<?php
namespace Class\Static;

class Routes {

    static array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static function get(string $route, array $serviceClassAndMethod) {
        self::addRoute('GET', $route, $serviceClassAndMethod);
    }

    public static function post(string $route, array $serviceClassAndMethod) {
        self::addRoute('POST', $route, $serviceClassAndMethod);
    }

    public static function put(string $route, array $serviceClassAndMethod) {
        self::addRoute('PUT', $route, $serviceClassAndMethod);
    }

    public static function delete(string $route, array $serviceClassAndMethod) {
        self::addRoute('DELETE', $route, $serviceClassAndMethod);
    }

    private static function addRoute(string $httpMethod, string $route, array $serviceClassAndMethod) {
        $arrayKeys = array('service', 'method');
        array_push(self::$routes[strtoupper($httpMethod)], ['endPoint' => $route, 'serviceAndMethod' => array_combine($arrayKeys, $serviceClassAndMethod)]);
    }
}
?>