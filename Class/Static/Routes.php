<?php
namespace Class\Static;

class Routes {

    public static array $routes = [
        'GET' => ['variable'=>[], 'noVariable'=>[]],
        'POST' => ['variable'=>[], 'noVariable'=>[]],
        'PUT' => ['variable'=>[], 'noVariable'=>[]],
        'DELETE' => ['variable'=>[], 'noVariable'=>[]]
    ];

    /**
     * Agrega una ruta de la api junto a la clase y el metodo que van a administrar esa ruta
     *
     * @param string $route
     * @param array $serviceClassAndMethod
     * @return void
     */
    public static function get(string $route, array $serviceClassAndMethod) {
        self::addRoute('GET', $route, $serviceClassAndMethod);
    }

    /**
     * Agrega una ruta de la api junto a la clase y el metodo que van a administrar esa ruta
     *
     * @param string $route
     * @param array $serviceClassAndMethod
     * @return void
     */
    public static function post(string $route, array $serviceClassAndMethod) {
        self::addRoute('POST', $route, $serviceClassAndMethod);
    }

    /**
     * Agrega una ruta de la api junto a la clase y el metodo que van a administrar esa ruta
     *
     * @param string $route
     * @param array $serviceClassAndMethod
     * @return void
     */
    public static function put(string $route, array $serviceClassAndMethod) {
        self::addRoute('PUT', $route, $serviceClassAndMethod);
    }

    /**
     * Agrega una ruta de la api junto a la clase y el metodo que van a administrar esa ruta
     *
     * @param string $route
     * @param array $serviceClassAndMethod
     * @return void
     */
    public static function delete(string $route, array $serviceClassAndMethod) {
        self::addRoute('DELETE', $route, $serviceClassAndMethod);
    }

    /**
     * Obtiene los metodos http que se encuentran disponibles en la api
     *
     * @return array
     */
    public static function getAvailableHttpMethods() {
        return array_keys(self::$routes);
    }

    /**
     * Retorna un array que contiene todas las rutas existentes para uno de los metodos http disponibles en la api rest
     *
     * @param string $method
     * @return array
     */
    public static function getAvailableRoutes(string $method) {
        return self::getAllEndPoints(self::$routes[strtoupper($method)]);
    }

    /**
     * Obtiene un array que contiene nombre del controller y metodo encargados de administrar el endpoint enviado en la request
     *
     * @param string $method
     * @param string $route
     * @return array
     */
    public static function getRouteData(string $method, string $route) {
        //self::$routes[strtoupper($method)];
        foreach(self::$routes[strtoupper($method)] as $x) {
            if($x["route"] === $route) {
                return $x["controllerAndMethod"];
            }
        }
    }

    /**
     * Agrega un array de elementos dentro del atributo estatico de clase $routes
     *
     * @param string $httpMethod
     * @param string $route
     * @param array $serviceClassAndMethod
     * @return void
     */
    private static function addRoute(string $httpMethod, string $route, array $serviceClassAndMethod) {
        $arrayKeys = array('controller', 'method');
        $pattern = '/' . '\{[a-zA-Z_]+[a-zA-Z0-9_]+\}' . '/';
        $option = preg_match($pattern, $route)?'variable':'noVariable';
        array_push(self::$routes[strtoupper($httpMethod)][$option], ['route' => $route, 'controllerAndMethod' => array_combine($arrayKeys, $serviceClassAndMethod)]);
    }

    /**
     * Obtiene todos los endPoints de un array perteneciente a uno de los metodos http aceptados por el servidor
     *
     * @param array $arrayRoutes
     * @return array
     */
    private static function getAllEndPoints(array $arrayRoutes) {
        //Verificar este metodo, produce un error
        $newArray = [];
        echo "<pre>";
        var_dump($arrayRoutes['variable'], $arrayRoutes['noVariables']);exit;
        foreach($arrayRoutes as $dataRoute) {
            array_push($newArray, $dataRoute['route']);
        }
        return $newArray;
    }

    /**
     * Verifica si la ruta contiene valores variables en ciertas partes de su estructura
     *
     * @param string $route
     * @return boolean
     */
    private static function checkRouteIsVariable(string $route):bool {
        $pattern = '/' . '\{[a-zA-Z_]+[a-zA-Z0-9_]+\}' . '/';
        if(preg_match($pattern, $route)) {
            return true;
        }else {
            return false;
        }
    }
}
?>