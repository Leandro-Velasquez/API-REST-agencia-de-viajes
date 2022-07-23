<?php
namespace Class\Static;

class Request {
    
    public string $uri;
    public string $methodHttp;
    public array $headers;
    public $body;

    public function __construct(string $uri, string $methodHttp, array $headers, $body)
    {
        $this->uri = $uri;
        $this->methodHttp = $methodHttp;
        $this->headers = $headers;
        $this->body = $body;
    }
}