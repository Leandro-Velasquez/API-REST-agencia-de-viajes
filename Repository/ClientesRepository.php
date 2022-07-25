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

    public static function insert(array $data) {
        extract($data);
        $sql = 'INSERT INTO ' . self::$table . ' (nombre, apellido, dni,id_vuelo) VALUES (:nombre, :apellido, :dni, :id_vuelo)';

        $stmt = DB::connect()->prepare($sql);

        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':id_vuelo', $id_vuelo);

        return $stmt->execute();
    }

    public static function lastId() {
        $sql = 'SELECT MAX(id) as id FROM ' . self::$table;
        $stmt = DB::connect()->query($sql);
        return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
    }
}

?>