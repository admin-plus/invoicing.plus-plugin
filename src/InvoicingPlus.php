<?php

namespace AdminPlus\InvoicingPlusPlugin;

use Illuminate\Support\Facades\Http;

class InvoicingPlus
{

    public $token;
    public $headers;

    public static function sayHello()
    {
        echo "Hello World";
    }

    public function __construct($token, $company)
    {
        $this->token = $token;
        $this->headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'accept' => 'application/json',
        ];
        $this->headers['X-company'] = $company;
    }

    public function postData($path, $params = null)
    {
        return Http::invoicing()->withHeaders($this->headers)->post($path, $params);
    }

    public function putData($path, $params = null)
    {
        return Http::invoicing()->withHeaders($this->headers)->put($path, $params);
    }

    public function getData($path, $params = null)
    {
        return Http::invoicing()->withHeaders($this->headers)->get($path, $params);
    }

    public function delete($path)
    {
        return Http::invoicing()->withHeaders($this->headers)->delete($path);
    }

    public function getPDF($path, $params = null)
    {
        return Http::invoicing()->withHeaders($this->headers)->get($path, $params);
    }

}
