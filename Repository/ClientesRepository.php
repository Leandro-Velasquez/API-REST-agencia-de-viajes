<?php

namespace Repository;

use Class\Static\DB;
use PDO;

class ClientesRepository {

    private static $table = 'clientes';

    public static function getAll() {
        $sql = 'SELECT * FROM ' . self::$table;
        $stmt = DB::connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {

    }

    public static function insert() {

    }
}

?>