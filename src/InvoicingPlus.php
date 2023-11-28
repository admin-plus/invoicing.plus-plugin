<?php

namespace AdminPlus\InvoicingPlusPlugin;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\CurlHandler;

class InvoicingPlus
{
    const BASE_URI = 'https://api.invoicing.plus/v1/';
    public $client;
    public $token;
    public $company;

    public function __construct($token = false, $company = false)
    {
        $this->token = $token;
        $this->company = $company;
        self::buildClient();
    }

    function add_header($header, $value)
    {
        return function (callable $handler) use ($header, $value) {
            return function (
                RequestInterface $request,
                array $options
            ) use ($handler, $header, $value) {
                $request = $request->withHeader($header, $value);
                return $handler($request, $options);
            };
        };
    }

    public function buildClient()
    {
        $stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        if ($this->token) {
            $stack->push(self::add_header('Authorization', 'Bearer ' . $this->token));
        }
        if ($this->company) {
            $stack->push(self::add_header('X-company', $this->company));
        }
        $this->client = new Client(['base_uri' => self::BASE_URI, 'handler' => $stack]);
    }

    public function setToken($token)
    {
        $this->company = $token;
        self::buildClient();
    }

    public function setCompany($company)
    {
        $this->company = $company;
        self::buildClient();
    }

    public function getData($path, $params = null)
    {
        try {
            return new InvoicingPlusResponse($this->client->get($path));
        } catch (ClientException $e) {
            return new InvoicingPlusResponse($e->getResponse());
        }
    }

    public function postData($path, $params = null)
    {
        try {
            return new InvoicingPlusResponse($this->client->post($path, [
                'json' => $params
            ]));
        } catch (ClientException $e) {
            return new InvoicingPlusResponse($e->getResponse());
        }
    }

    public function check()
    {
        return $this->getData('check');
    }

    public function newToken($email, $password)
    {
        $response = $this->postData('token', ['email' => $email, 'password' => $password]);
        if ($response->successful()) {
            $this->token = $response->data()->token;
            self::buildClient();
        }
        return $response;
    }

    public function companies()
    {
        return $this->getData('companies');
    }

    public function customers()
    {
        return $this->getData('customers');
    }

}
