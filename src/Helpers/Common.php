<?php

namespace Duynv\BaokimSdk\Helpers;

use GuzzleHttp\Client;

class Common {

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
