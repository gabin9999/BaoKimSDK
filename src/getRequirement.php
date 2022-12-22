<?php

namespace Duynv\BaokimSdk;

require_once(__DIR__ . '/../config/config.php');

use Duynv\BaokimSdk\Helpers\Common;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class getRequirement {

    public static $apiKey;
    public static $apiSecret;
    public static $_jwt;
    public static $apiUrl = API_URL;
    public static $baseUri = BASE_URI;
    const TOKEN_EXPIRE = 600;

    public static function setKey($apiKey, $apiSecret)
    {
        self::$apiKey = $apiKey;
        self::$apiSecret = $apiSecret;
        self::getToken();
    }

    public static function setUrl($apiUrl, $baseUri = '') {
        self::$apiUrl = $apiUrl;
        if ($baseUri) {
            self::$baseUri = $baseUri;
        }
    }

    public static function getToken(){
        if(!self::$_jwt)
            self::refreshToken(self::$apiKey, self::$apiSecret);
        return self::$_jwt;
    }
    public static function refreshToken($apiKey, $apiSecret)
    {
        $issuedAt   = time();
        $expire     = $issuedAt + self::TOKEN_EXPIRE;
        $token = array(
            'iat'  => $issuedAt,
            "iss" => $apiKey,
            "aud" => $apiSecret,
            'exp'  => $expire,
        );

        /**
         * IMPORTANT:
         * You must specify supported algorithms for your application. See
         * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
         * for a list of spec-compliant algorithms.
         */
        self::$_jwt = JWT::encode($token, $apiSecret, 'HS256');
        return self::$_jwt;
    }
}
