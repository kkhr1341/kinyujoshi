<?php

namespace WebPay;

use GuzzleHttp\Client as GuzzleClient;

use WebPay\Data\EventResponse;
use WebPay\ErrorResponse\InvalidRequestException as ERInvalidRequestException;
use WebPay\ErrorResponse\AuthenticationException as ERAuthenticationException;
use WebPay\ErrorResponse\CardException as ERCardException;
use WebPay\ErrorResponse\ApiException as ERApiException;

class WebPay
{
    /** @var GuzzleClient */
    private $client;
    private $acceptLanguage;

    /** @var Charge */
    private $charge;
    /** @var Customer */
    private $customer;
    /** @var Token */
    private $token;
    /** @var Event */
    private $event;
    /** @var Shop */
    private $shop;
    /** @var Recursion */
    private $recursion;
    /** @var Account */
    private $account;

    /**
     * @param array $options API options
     */
    public function __construct($authToken, $options = array())
    {
        $apiBase = isset($options['api_base']) ? $options['api_base'] : 'https://api.webpay.jp/v1';
        if (substr($apiBase, -1) != '/') {
            $apiBase .= '/';
        }
        $this->acceptLanguage = 'en';
        $config = ['base_uri' => $apiBase, 'headers' => []];

        $config['headers']['Authorization'] = 'Bearer ' . $authToken;

        $config['headers']['Content-Type'] = "application/json";

        $config['headers']['Accept'] = "application/json";

        $config['headers']['User-Agent'] = "Apipa-webpay/2.3.2 php";

        $config['headers']['Accept-Language'] = "en";
        $this->client = new GuzzleClient($config);

        $this->charge = new Charge($this);
        $this->customer = new Customer($this);
        $this->token = new Token($this);
        $this->event = new Event($this);
        $this->shop = new Shop($this);
        $this->recursion = new Recursion($this);
        $this->account = new Account($this);
    }

    public function setAcceptLanguage($value)
    {
        $this->acceptLanguage = $value;
    }

    /**
     * Decode request body sent as Webhook
     *
     * @param  string        $requestBody JSON string
     * @return EventResponse object that represents webhook data or null
     */
    public function receiveWebhook($requestBody)
    {
        $decodedJson = json_decode($requestBody, true);
        if (!$decodedJson) {
            throw new ApiConnectionException('Webhook request body is invalid JSON string', null);
        }

        return new EventResponse($decodedJson);
    }

    public function __get($key)
    {
        $accessors = array('charge', 'customer', 'token', 'event', 'shop', 'recursion', 'account');
        if (in_array($key, $accessors) && property_exists($this, $key)) {
            return $this->{$key};
        } else {
            throw new \Exception('Unknown accessor ' . $key);
        }
    }

    public function __set($key, $value)
    {
        throw new \Exception($key . ' is not able to override');
    }

    /**
     * Dispatch API request
     *
     * @param string $method    HTTP method
     * @param string $path      Target path relative to base_url option value
     * @param object $paramData Request data
     *
     * @return mixed Response object
     */
    public function request($method, $path, $paramData)
    {
        $options = [
            'query' => [],
            'headers' => ['Accept-Language' => $this->acceptLanguage],
        ];
        foreach ($paramData->queryParams() as $k => $v) {
            $options['query'][$k] = $v === false ? 'false' : ($v === true ? 'true' : $v);
        }
        if ($method !== 'get' && $method !== 'delete') {
            $body = $paramData->requestBody();
            $options['body'] = empty($body) ? '{}' : json_encode($body);
            $optoins['headers']['Content-Type'] = 'application/json';
        }
        try {
            $response = $this->client->request($method, $path, $options);
            $json = json_decode($response->getBody(), true);
            if ($json === null) {
                throw ApiConnectionException::invalidJson($e);
            }

            return $json;
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $this->throwErrorResponseException($e->getResponse());
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw ApiConnectionException::inRequest($e);
        }
    }

    private function throwErrorResponseException($response)
    {
        $data = json_decode($response->getBody(), true);
        if ($data === null) {
            throw ApiConnectionException::invalidJson($e);
        }
        $status = $response->getStatusCode();
        if ($status == 400) {
            throw new ERInvalidRequestException($status, $data);
        }
        if ($status == 401) {
            throw new ERAuthenticationException($status, $data);
        }
        if ($status == 402) {
            throw new ERCardException($status, $data);
        }
        if ($status == 404) {
            throw new ERInvalidRequestException($status, $data);
        }
        if (true) {
            throw new ERApiException($status, $data);
        }
        throw new \Exception("Unknown error is returned");
    }
}
