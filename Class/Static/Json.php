<?php
namespace Class\Static;

class Json {

    public static function convertirAFormatoJson(array $bodyResponse) {
        return json_encode($bodyResponse);
    }

    public static function convertirJsonAFormatoObject(string $dataJson) {
        return json_decode($dataJson, false);
    }

    public static function convertirJsonAFormatoArrayAsociativo(string $dataJson) {

    }
}
?>