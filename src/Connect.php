<?php

namespace Duynv\BaokimSdk;

use Duynv\BaokimSdk\Helpers\Common;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class Connect {

    const ERR_NONE = 0;
    protected $merchantId = 400734;
    protected $apiKey = '';
    protected $apiSecret = '';
    protected $apiUrl = 'https://dev-api.baokim.vn';
    protected $_jwt;
    const TOKEN_EXPIRE = 600;

    public function createOrder($data) {
        $Common = new Common();
        try{
            $jwt = $this->getToken();
            $header = [
                'jwt' => 'Bearer '.$jwt,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ];
            $rs = $Common->requestAPI('POST', $this->apiUrl.'/payment/api/v5/order/send', $header, [], $data);
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
    public function getToken(){
        if(!$this->_jwt)
            $this->refreshToken();

        return $this->_jwt;
    }
    public function refreshToken()
    {
        $issuedAt   = time();
        $expire     = $issuedAt + self::TOKEN_EXPIRE;
        $token = array(
            'iat'  => $issuedAt,
            "iss" => $this->apiKey,
            "aud" => $this->apiUrl,
            'exp'  => $expire,
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        $this->_jwt = JWT::encode($token, $this->apiSecret, 'HS256');
    }
}
