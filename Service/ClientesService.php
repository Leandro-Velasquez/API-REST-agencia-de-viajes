<?php
namespace Service;

use Class\Static\ErrorMessage;
use Class\Static\RequestValidator;
use InvalidArgumentException;
use Repository\ClientesRepository;

class ClientesService {

    public function getAllClients() {

    }

    public function getById($id) {
        
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