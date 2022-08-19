<?php

namespace Class\Static;

use InvalidArgumentException;

class ProcessRequest {

    public static function process(Request $request) {
        if(self::validate($request)) {
            $routeApi = self::searchRoute($request);
            extract(Routes::getControllerAndMethod($request->methodHttp, $routeApi, self::containsVariables($request->uri)));
            $id = self::getVariableValue($request->uri);

            $obj = new $controller;
            if(self::containsVariables($request->uri)) {
                $response = call_user_func_array(array($obj, $method), array('id'=>$id));
            }else {
                if(isset($request->body)) {
                    $response = call_user_func_array(array($obj, $method), array($request->body));
                }else {
                    $response = call_user_func_array(array($obj, $method), array());
                }
            }
            
            return $response;
        }
    }

    private static function validate(Request $request) {
        if(RequestValidator::checkMethodHttp($request->methodHttp)) {
            if(self::searchRoute($request)) {
                return true;
            }
            else {
                if(!self::checkIdInUrl($request->methodHttp, $request->uri)) {
                    StatusCode::setStatusCode(404);
                    throw new InvalidArgumentException('Debe proporcionar un id en la url');
                }
                StatusCode::setStatusCode(501);
                throw new InvalidArgumentException('La ruta no se encuentra definida en la api');
            }
        }else {
            StatusCode::setStatusCode(501);
            throw new InvalidArgumentException('El metodo no esta definido en la api');
        }
    }


    /**
     * Comprueba si la ruta enviada en la request se encuentra definida en la api de ser asi devuelve la ruta almacenada en el server caso contrario devuelve false
     *
     * @param Request $request
     * @return void
     */
    private static function searchRoute(Request $request) {
        if(self::containsVariables($request->uri)) {
            $routes = Routes::getAllRoutesVariables($request->methodHttp);
            foreach($routes as $route) {
                if($route === self::replaceNumber('{'.self::getNameVariable($route).'}', $request->uri)) {
                    return $route;
                }
            }
        }else if(!self::containsVariables($request->uri)) {
            $routes = Routes::getAllRoutesNoVariables($request->methodHttp);
            foreach($routes as $route) {
                if($route === $request->uri) {
                    return $route;
                }
            }
        }else {
            return false;
        }
    }

    /**
     * Reemplaza los numeros en una ruta por un nuevo valor
     *
     * @param string $newValue
     * @param string $string
     * @return void
     */
    private static function replaceNumber(string $newValue, string $string) {
        $s = explode('/', $string);
        foreach($s as &$x) {
            if(is_numeric($x)) {
                $x = $newValue;
            }
        }
        return implode('/', $s);
    }

    /**
     * Obtiene el nombre de la variable declarada en la ruta almacenada en la api
     *
     * @param string $s
     * @return void
     */
    private static function getNameVariable(string $s) {
        $pattern = '/' . '\{([a-zA-Z_]+[0-9]*[a-zA-Z_])\}' . '/';
        preg_match($pattern, $s, $match);
        return $match[1];
    }

    /**
     * Comprobamos si la url solicitada por la request contiene valores variables
     *
     * @param Request $request
     * @return bool
     */
    private static function containsVariables(string $routeRequest):bool {
        $patternVariable = '/' . '[a-z]+\/((\d+)\/?|[a-z]+\/(\d+)\/?)$' . '/';
        if(preg_match($patternVariable, $routeRequest)) {
            return true;
        }else {
            return false;
        }
    }

    /**
     * Obtenemos el valor de la variable ubicada en la url pasada en la request
     *
     * @param Request $request
     * @return void
     */
    private static function getVariableValue(string $routeRequest) {
        $patternVariable = '/' . '^[a-z]+\/(\d+)\/?$|^[a-z]+\/[a-z]+\/(\d+)\/?$' . '/';
        if(preg_match($patternVariable, $routeRequest, $match)) {
            foreach($match as $x) {
                if(is_numeric($x)) {
                    return $x;
                }
            }
        }
    }

    /**
     * Comprueba si pasamos un id en la url
     *
     * @param string $methodHttp
     * @param string $routeRequest
     * @return boolean
     */
    private static function checkIdInUrl(string $methodHttp, string $routeRequest):bool {
        $allRoutes = Routes::getAllRoutesHttpMethod($methodHttp);
        $arrRouteRequest = explode('/', $routeRequest);
        foreach($allRoutes as $r) {
            $a = explode('/', $r);
            if(count(array_diff($arrRouteRequest, $a)) == 0) {
                return false;
            }
        }
        return true;
    }
}
?>