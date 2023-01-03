<?php

namespace Duynv\BaokimSdk;

class Webhook {
    public $sec;

    public function __construct($sec)
    {
        $this->sec = $sec;
    }

    /**
     * @param $jsonWebhookData JSON format
     * @return bool
     */
    public function verify($jsonWebhookData)
    {
        $webhookData = json_decode($jsonWebhookData, true);

        $baokimSign = $webhookData['sign'];
        unset($webhookData['sign']);

        $signData = json_encode($webhookData);

        $secret = $this->sec;
        $mySign = hash_hmac('sha256', $signData, $secret);

        return $baokimSign == $mySign;
    }
}

?>