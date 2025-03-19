<?php 

namespace Ttimot24\TeyaPayment;

use \GuzzleHttp\RequestOptions;

class TeyaApiClient extends TeyaClientBase
{

    private static $_PAYMENT_ENDPOINT = "/rpg/api/payment";

    protected $rules = ['PrivateKey'];

    protected $defaultConfig = [
        'environment' => 'sandbox',
        'headers' => [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]
    ];

    public function preauth(array $data){

        $data['TransactionType'] = "PreAuthorization";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, [RequestOptions::JSON => $data, RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function payment(array $data){

        $data['TransactionType'] = "Sale";
        $data['TransactionDate'] = date("c");

        $response = $this->http->post(self::$_PAYMENT_ENDPOINT, [RequestOptions::JSON => $data, RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function transaction($id){

        $response = $this->http->get(self::$_PAYMENT_ENDPOINT."/".$id, [RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function capture($id){
        $response = $this->http->put(self::$_PAYMENT_ENDPOINT."/".$id."/capture", [RequestOptions::JSON => [], RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function cancel($token){
        $response = $this->http->delete('/api/token/single/'.$token, [RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }

    public function refund($id){
        $response = $this->http->put(self::$_PAYMENT_ENDPOINT."/".$id."/refund", [RequestOptions::JSON => [], RequestOptions::AUTH => [$this->getConfig('PrivateKey'), null]]);

        return $response;
    }


}