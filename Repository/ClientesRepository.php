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

    public static function insert($dni, $nombre, $apellido, $idVuelo) {
        $sql = 'INSERT INTO ' . self::$table . ' (dni, nombre, apellido, id_vuelo) VALUES (:dni, :nombre, :apellido, :idVuelo)';

        $stmt = DB::connect()->prepare($sql);

        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':idVuelo', $idVuelo);

        return $stmt->execute();
    }
}

?>