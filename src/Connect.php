<?php

namespace Duynv\BaokimSdk;

require_once(__DIR__ . '/../config/config.php');

use Duynv\BaokimSdk\Helpers\Common;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class Connect {

    public function createOrder($data) {
        $Common = new Common();
        $jwt = getRequirement::$_jwt;
        try{
            $header = [
                'jwt' => 'Bearer '.$jwt,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $rs = $Common->requestAPI('POST', API_URL.'/payment/api/v5/order/send', $header, [], $data);
            $responseMassage = $rs->body->message;
            $dataRespone = [
                'responseCode' => 99,
                'responseMessage' => ($responseMassage) ? $responseMassage[0] : ''
            ];
            return $dataRespone;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
