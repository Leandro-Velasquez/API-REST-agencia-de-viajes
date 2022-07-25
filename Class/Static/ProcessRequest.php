<?php

namespace Class\Static;

use InvalidArgumentException;

class ProcessRequest {

    public static function process(Request $request) {
        if(self::validate($request)) {
            extract(Routes::getRouteData($request->methodHttp, $request->uri));
            $obj = new $controller;
            $response = call_user_func_array(array($obj, $method), array());
            return $response;
        }
    }

    public static function validate(Request $request) {
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
}
?>