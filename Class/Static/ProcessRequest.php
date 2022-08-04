<?php

namespace Class\Static;

use InvalidArgumentException;

class ProcessRequest {

    public static function process(Request $request) {
        if(self::validate($request)) {
            /*extract(Routes::getRouteData($request->methodHttp, $request->uri));
            $obj = new $controller;
            $response = call_user_func_array(array($obj, $method), array($request));
            return $response;*/

        }
    }

    private static function validate(Request $request) {
        if(RequestValidator::checkMethodHttp($request->methodHttp)) {
            if(RequestValidator::checkRoute($request->methodHttp, $request->uri)) {
                return true;
            }
            else {
                StatusCode::setStatusCode(501);
                throw new InvalidArgumentException('La ruta no se encuentra definida en la api');
            }
        }else {
            StatusCode::setStatusCode(501);
            throw new InvalidArgumentException('El metodo no esta definido en la api');
        }
    }






    /**
     * Comprobamos si la url solicitada por la request contiene valores variables
     *
     * @param Request $request
     * @return bool
     */
    private static function containsVariables(Request $request):bool {
        $patternVariable = '/' . '[a-z]+\/((\d+)\/?|[a-z]+\/(\d+)\/?)$' . '/';
        if(preg_match($patternVariable, $request->uri)) {
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
    private static function getVariableValue(Request $request) {
        $patternVariable = '/' . '^[a-z]+\/(\d+)\/?$|^[a-z]+\/[a-z]+\/(\d+)\/?$' . '/';
        if(preg_match($patternVariable, $request->uri, $match)) {
            foreach($match as $x) {
                if(is_numeric($x)) {
                    return $x;
                }
            }
        }
    }
}
?>