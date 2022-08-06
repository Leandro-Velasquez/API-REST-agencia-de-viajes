<?php

namespace Controllers;

use Class\Static\ErrorMessage;
use Class\Static\JsonConverter;
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
            throw new InvalidArgumentException(ErrorMessage::ERROR_RECURSO_INEXISTENTE);
        }
    }

    public function registerClient($req) {
        $id = ClientesRepository::insert($req->body)?ClientesRepository::lastId():null;
        $statusCode = $id ? 201: 501;
        $r = new Response(array('Content-Type:application/json'), $statusCode, JsonConverter::convertToJson(array('id'=>$id)));
        return $r;
    }

    public function deleteClient($id) {
        if(ClientesRepository::delete($id)) {
            $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(array('id'=>$id)));
            return $r;
        }
    }

    public function updateClientById($req) {
        if(ClientesRepository::update($req->body)) {
            $r = new Response(array(), 200, array('id'=>$req->body['id']));
            return $r;
        }else {
            throw new InvalidArgumentException('Hubo un problema al actualizar los datos, vuelva a intentarlo');
        }
    }
}
?>