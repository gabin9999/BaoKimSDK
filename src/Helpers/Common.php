<?php

namespace Duynv\BaokimSdk\Helpers;

use GuzzleHttp\Client;

class Common {

    const ERR_NONE = 0;
    protected $merchantId = 400734;
    protected $apiKey = 'iIcJMU32wzuemkQUZ495CXvqnhnxKdR0';
    protected $apiSecret = 'D8BB7icFvOTgQ9xgS2li0OufgWnDQLMm';
    protected $apiUrl = 'https://dev-api.baokim.vn';
    protected $_jwt;
    const TOKEN_EXPIRE = 600;


    function requestAPI($method, $url, $headers, $query = [], $params = [])
    {
        $res = new \stdClass();
        $res->httpResCode = 200;
        $res->body = null;

        $client = new Client(['timeout' => 60.0]);

        $options['query'] = $query;
        $options['body'] = json_encode($params);
        $options['headers'] = $headers;

        try {
            $rs = $client->request($method, $url, $options);
            $res->httpResCode = $rs->getStatusCode();
            $body = json_decode($rs->getBody()->getContents());
            $res->body = $body;
        } catch (\Exception $e) {
            $res->httpResCode = 500;
            $res->body = $e;
        }

        return $res;
    }}
