<?php

namespace Class\Static;

class JsonConverter {

    public static function convertToJson(array $bodyResponse) {
        return json_encode($bodyResponse);
    }

    public static function convertJsonToObject(string $dataJson) {
        return json_decode($dataJson, false);
    }

    public static function convertJsonToArray(string $dataJson) {
        return json_decode($dataJson, true);
    }
}

?>