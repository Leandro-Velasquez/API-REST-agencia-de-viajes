<?php
ini_set('display_errors', 1);
require "autoload.php";
require "web.php";

use Class\Static\JsonConverter;
use Class\Static\ProcessRequest;
use Class\Static\Request;
use Class\Static\Response;
use Class\Static\Server;
use Class\Static\StatusCode;

try {
    $req = new Request(Server::getUri(), Server::getHttpMethod(), Server::getAllHeadersRequest(), Server::getBody());
    $res = ProcessRequest::process($req);
    $res->send();
}catch(Exception $e) {
    $response = new Response;
    $response->setHeaders(array('Content-Type:application/json'));
    $response->setBody(JsonConverter::convertToJson(array('error'=>$e->getMessage())));
    $response->setStatusCode(StatusCode::getStatusCode());
    $response->send();
}
?>