<?php
namespace Service;

use Class\Static\ErrorMessage;
use Class\Static\Request;
use Class\Static\RequestValidator;
use Class\Static\Response;
use InvalidArgumentException;
use Repository\ClientesRepository;

class ClientesService {

    public function getAllClients() {
        return ClientesRepository::getAll();
    }

    public function getById($id) {
        if($data = ClientesRepository::getById($id)) {
            return $data;
        }else {
            throw new InvalidArgumentException('El recurso con id ' . $id . ' no se encuentra registrado en la base de datos');
        }
    }

    public function create($data) {
        $columsNames = ClientesRepository::getColumnNames();
        $columnsUnique = ClientesRepository::getColumnsUnique();
        RequestValidator::validateDataCreateResource($data, $columsNames, $columnsUnique);
        if(ClientesRepository::insert($data)) {
            return ClientesRepository::lastId();
        }else {
            throw new InvalidArgumentException('Hubo un problema al crear el recurso');
        }
    }

    public function deleteById($id) {
        if(ClientesRepository::getById($id)) {
            ClientesRepository::delete($id);
        }else {
            throw new InvalidArgumentException('No se encontro ningun recurso con el id ' . $id . ' para ser eliminado');
        }
    }

    public function updateById(array $info) {
        $columsNames = ClientesRepository::getColumnNames();
        RequestValidator::validateOperationsCrud($info, $columsNames);
        if($dataDb = ClientesRepository::getById($info['id'])) {
            $ar = array_diff_key($dataDb, $info);
            $newValues = array_merge($info, $ar);
            ClientesRepository::update($newValues);
        }else {
            throw new InvalidArgumentException(ErrorMessage::ERROR_UPDATE_RECURSO_INEXISTENTE);
        }
    }
}
?>