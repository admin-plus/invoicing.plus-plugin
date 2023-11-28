<?php

namespace AdminPlus\InvoicingPlusPlugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7;

class InvoicingPlusResponse
{
    public $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function successful()
    {
        return $this->response->getStatusCode() >= 200 && $this->response->getStatusCode() < 300;
    }

    public function data()
    {
        return json_decode($this->response->getBody())->data;
    }

    public function metadata()
    {
        return json_decode($this->response->getBody())->metadata;
    }

    public function error()
    {
        return json_decode($this->response->getBody());
    }



}
