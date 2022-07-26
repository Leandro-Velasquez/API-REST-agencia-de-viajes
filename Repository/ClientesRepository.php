<?php

namespace Repository;

use Class\Static\DB;
use PDO;
use PDOException;

class ClientesRepository {

    private static $table = 'clientes';

    public static function getAll() {
        $sql = 'SELECT * FROM ' . self::$table;
        $stmt = DB::connect()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getById($id) {
        $sql = 'SELECT * FROM ' . self::$table . ' WHERE id=:id';
        $stmt = DB::connect()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public static function delete($id) {
        $sql = 'DELETE FROM ' . self::$table . ' WHERE id=:id';
        $stmt = DB::connect()->prepare($sql);

        $stmt->bindParam(':id', $id);

        $r = $stmt->execute();
        return $r;
    }

    public static function update(array $data) {
        extract($data);
        $sql = 'UPDATE ' . self::$table . ' SET nombre=:n, apellido=:a, dni=:d, id_vuelo=:iv WHERE id=:id';
        $stmt = DB::connect()->prepare($sql);
        $stmt->bindParam(':n', $nombre);
        $stmt->bindParam(':a', $apellido);
        $stmt->bindParam(':d', $dni);
        $stmt->bindParam(':iv', $id_vuelo);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public static function getColumnNames() {
        $stmt = DB::connect()->query('SHOW COLUMNS FROM ' . self::$table);
        $columsNames = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $x) {
            array_push($columsNames, $x['Field']);
        }
        return $columsNames;
    }

    public static function getColumnsUnique() {
        $tableName = self::$table;
        $sql = <<<SQL
            SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
            WHERE TABLE_NAME='$tableName' 
            and COLUMN_KEY in ('UNI')
        SQL;
        $stmt = DB::connect()->query($sql);
        $columnsUnique = [];
        foreach($stmt->fetchAll(PDO::FETCH_ASSOC) as $x) {
            array_push($columnsUnique, $x['COLUMN_NAME']);
        }
        return $columnsUnique;
    }

    public static function searchValueDniColumn($value) {
        $tableName = self::$table;
        $sql = <<<SQL
            SELECT dni FROM $tableName WHERE dni=:d
        SQL;
        $stmt = DB::connect()->prepare($sql);
        $stmt->bindParam(':d', $value);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>