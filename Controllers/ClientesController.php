<?php

namespace Controllers;

use Class\Static\JsonConverter;
use Class\Static\Response;
use Exception;
use Repository\ClientesRepository;
use Service\ClientesService;

class ClientesController {

    private ClientesService $clientesService;

    public function __construct()
    {
        $this->clientesService = new ClientesService;
    }

    public function getAllClients() {
        $response = new Response;
        $response->setHeaders(array('Content-Type:application/json'));
        $response->setBody(JsonConverter::convertToJson($this->clientesService->getAllClients()));
        $response->setStatusCode(200);
        return $response;
    }

    public function getClientById($id) {
        try {
            $data = $this->clientesService->getById($id);
            $response = new Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson($data));
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

    public function registerClient($data) {
        try {
            $id = $this->clientesService->create($data);

            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('id'=>$id)));
            $response->setStatusCode(201);
            return $response;
        }catch(Exception $e) {
            $response = New Response;
            $response->setHeaders(array('Content-Type:application/json'));
            $response->setBody(JsonConverter::convertToJson(array('error'=>$e->getMessage())));
            $response->setStatusCode(404);
            return $response;
        }
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