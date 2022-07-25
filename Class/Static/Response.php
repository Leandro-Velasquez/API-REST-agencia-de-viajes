<?php

namespace Class\Static;

class Response {
    
    private array $headers;
    private int $statusCode;
    private $body;

    public function __construct(array $headers, int $statusCode, $body)
    {
        $this->headers = $headers;
        $this->statusCode = $statusCode;
        $this->body = $body;
    }

    public function send() {
        foreach($this->headers as $header) {
            header($header);
        }
        http_response_code($this->statusCode);
        echo $this->body;
    }



    //Metodos getters y setters
    
    public function getHeaders() {
        return $this->headers;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }

    public function getBody() {
        return $this->body;
    }

    public function setHeaders(array $headers) {
        $this->headers = $headers;
    }

    public function setStatusCode(int $statusCode) {
        $this->statusCode = $statusCode;
    }

    public function setBody($body) {
        $this->body = $body;
    }
}
?>