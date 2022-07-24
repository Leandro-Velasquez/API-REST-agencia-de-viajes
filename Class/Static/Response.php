<?php

namespace Class\Static;

class Response {
    
    private $headers;
    private $statusCode;
    private $body;

    public function __construct(array $headers, $statusCode, string $body)
    {
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function send() {

    }



    //Metodos getters y setters
    
    public function getHeaders() {

    }

    public function getStatusCode() {
        
    }

    public function getBody() {
        
    }

    public function setHeaders() {

    }

    public function setStatusCode() {
        
    }

    public function setBody() {
        
    }
}
?>