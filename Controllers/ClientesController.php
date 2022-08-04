<?php

namespace Controllers;

use Class\Static\JsonConverter;
use Class\Static\Response;
use Repository\ClientesRepository;

class ClientesController {

    public function getAllClients() {
        $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(ClientesRepository::getAll()));
        return $r;
    }

    public function getClientById($id) {
        $r = new Response(array('Content-Type:application/json'), 200, JsonConverter::convertToJson(ClientesRepository::getById($id)));
        return $r;
    }

    public function registerClient($req) {
        $id = ClientesRepository::insert($req->body)?ClientesRepository::lastId():null;
        $statusCode = $id ? 201: 501;
        $r = new Response(array('Content-Type:application/json'), $statusCode, JsonConverter::convertToJson(array('id'=>$id)));
        return $r;
    }
}
?>