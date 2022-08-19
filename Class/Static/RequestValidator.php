<?php

namespace Class\Static;

use InvalidArgumentException;
use Repository\ClientesRepository;

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

    /**
     * Comprueba que todas claves del cuerpo de la solicitud coincidan con los nombres de las columnas de la tabla
     *
     * @param array $keysBody
     * @param array $columnsNames
     * @return boolean
     */
    public static function checkBodyKeysWithColumnNames(array $keysBody, array $columnsNames):bool {
        $checkKeys = true;
        foreach($keysBody as $key) {
            if(!in_array($key, $columnsNames)) {
                $checkKeys = false;
            }
        }
        return $checkKeys;
    }

    /**
     * Obtiene todas las keys invalidas que no coinciden con los nombres de las columnas de la tabla
     *
     * @param array $keysBody
     * @param array $columnsNames
     * @return array
     */
    public static function getInvalidKeys(array $keysBody, array $columnsNames):array {
        $invalidKeys = [];
        foreach($keysBody as $key) {
            if(!in_array($key, $columnsNames)) {
                array_push($invalidKeys, $key);
            }
        }
        return $invalidKeys;
    }

    public static function validateOperationsCrud($info, $columnsNames) {
        if(isset($info['id'])) {
            if(count(self::getInvalidKeys(array_keys($info), $columnsNames)) == 0) {
                return true;
            }else {
                $invalidKeys = self::getInvalidKeys(array_keys($info), $columnsNames);
                throw new InvalidArgumentException('Se encontraron keys invalidas en el cuerpo de la solicitud: '. implode(', ', $invalidKeys));
            }
        }else {
            throw new InvalidArgumentException('Debe proporcionar un id en el cuerpo de la solicitud');
        }
    }

    public static function validateDataCreateResource($data, $columnsNames, $columnsUnique=null) {
        if(count(self::getInvalidKeys(array_keys($data), $columnsNames)) == 0) {
            if(!empty($columnsUnique)) {
                if(!ClientesRepository::searchValueDniColumn($data['dni'])) {
                    return true;
                }else {
                    throw new InvalidArgumentException('Los valores ingresados en el/los campo/s ' . implode(',', $columnsUnique) . ' ya se encuentran registrados');
                }
            }
        }else {
            $invalidKeys = self::getInvalidKeys(array_keys($data), $columnsNames);
            throw new InvalidArgumentException('Se encontraron keys invalidas en el cuerpo de la solicitud: '. implode(', ', $invalidKeys));
        }
    }
}