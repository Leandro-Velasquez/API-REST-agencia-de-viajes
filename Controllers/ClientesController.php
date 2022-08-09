<?php

namespace Controllers;

use Class\Static\ErrorMessage;
use Class\Static\JsonConverter;
use Class\Static\RequestValidator;
use Class\Static\Response;
use Class\Static\StatusCode;
use InvalidArgumentException;
use Repository\ClientesRepository;

class ClientesController {

    public function getAllClients() {
        $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(ClientesRepository::getAll()));
        return $r;
    }

    public function getClientById($id) {
        if($data = ClientesRepository::getById($id)) {
            $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson($data));
        return $r;
        }else {
            StatusCode::setStatusCode(404);
            throw new InvalidArgumentException(ErrorMessage::ERROR_GET_RECURSO_INEXISTENTE);
        }
    }

    public function registerClient($req) {
        $id = ClientesRepository::insert($req->body)?ClientesRepository::lastId():null;
        $statusCode = $id ? 201: 501;
        $r = new Response(array('Content-Type:application/json'), $statusCode, JsonConverter::convertToJson(array('id'=>$id)));
        return $r;
    }

    public function deleteClient($id) {
        if(ClientesRepository::getById($id)) {
            ClientesRepository::delete($id);
            $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(array('id'=>$id)));
            return $r;
        }else {
            StatusCode::setStatusCode(404);
            throw new InvalidArgumentException(ErrorMessage::ERROR_DELETE_RECURSO_INEXISTENTE);
        }
    }

    public function updateClientById($req) {
        $columsNames = ClientesRepository::getColumnNames();
        $keysBody = array_keys($req->body);
        if(isset($req->body['id'])) {
            $invalidKeys = RequestValidator::getInvalidKeys($keysBody, $columsNames);
            if(count($invalidKeys) == 0) {
                if($dataDb = ClientesRepository::getById($req->body['id'])) {
                    $ar = array_diff_key($dataDb, $req->body);
                    $newValues = array_merge($req->body, $ar);
                    ClientesRepository::update($newValues);
                    $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(array('id'=>$req->body['id'])));
                    return $r;
                }else {
                    StatusCode::setStatusCode(404);
                    throw new InvalidArgumentException(ErrorMessage::ERROR_UPDATE_RECURSO_INEXISTENTE);
                }
            }else {
                StatusCode::setStatusCode(404);
                throw new InvalidArgumentException(ErrorMessage::ERROR_KEYS_INVALIDAS);
            }
        }else {
            StatusCode::setStatusCode(404);
            throw new InvalidArgumentException(ErrorMessage::ERROR_ID_NO_PROPORCIONADO);
        }
    }
}
?>