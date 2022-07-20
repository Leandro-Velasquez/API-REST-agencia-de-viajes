<?php
namespace Class\Static;

class Json {

    public static function convertirAFormatoJson(array $bodyResponse) {
        return json_encode($bodyResponse);
    }

    public static function convertirJsonAFormatoObject(string $dataJson) {

    }

    public static function convertirJsonAFormatoArrayAsociativo(string $dataJson) {

    }
}
?>