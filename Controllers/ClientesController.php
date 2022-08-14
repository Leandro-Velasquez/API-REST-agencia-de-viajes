<?php

namespace Controllers;

use Class\Static\ErrorMessage;
use Class\Static\JsonConverter;
use Class\Static\RequestValidator;
use Class\Static\Response;
use Class\Static\StatusCode;
use Exception;
use InvalidArgumentException;
use Repository\ClientesRepository;
use Service\ClientesService;

class ClientesController {

    private ClientesService $clientesService;

    public function __construct()
    {
        $this->clientesService = new ClientesService;
    }

    public function getAllClients() {
        $r = new Response;
        $r->setHeaders(array('Content-Type:application/json'));
        $r->setBody(JsonConverter::convertToJson(ClientesRepository::getAll()));
        $r->setStatusCode(200);
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
        try {
            $this->clientesService->deleteById($id);

            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('id'=>$id)));
            $response->setStatusCode(200);
            return $response;
        }catch(Exception $e) {
            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('error'=>$e->getMessage())));
            $response->setStatusCode(404);
            return $response;
        }
    }

    public function updateClientById($req) {
        try {
            $this->clientesService->updateById($req->body);

            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('id'=>$req->body['id'])));
            $response->setStatusCode(200);
            return $response;
        }catch(Exception $e) {
            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('error'=>$e->getMessage())));
            $response->setStatusCode(404);
            return $response;
        }
    }
}
?>