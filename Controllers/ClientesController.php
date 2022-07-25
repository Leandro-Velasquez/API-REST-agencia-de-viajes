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

    public function getClientById() {

    }

    public function registerClient() {

    }
}
?>